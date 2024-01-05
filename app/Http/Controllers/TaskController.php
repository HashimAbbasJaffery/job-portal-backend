<?php

namespace App\Http\Controllers;

use App\Events\DispatchMessage;
use App\Events\NotificationEvent;
use App\Jobs\SendTaskJob;
use App\Models\Task;
use Illuminate\Http\Request;
use App\Models\File;
use App\Models\Message;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    public function getTask(Task $task) {
        return view("task", compact("task"));
    }
    public function get() {
        $user_id = auth()->user()->id;

        $tasks = Task::where("user_id", $user_id)->get();

        return view("tasks", compact("tasks"));
    }
    public function create(User $user) {
        $user_id = $user->id;
        $files = File::all();
        return view("create_task", compact("files", "user_id"));
    }
    protected function storeMessageNotification($sender_id, $reciever_id, $message) {
        $notification = Notification::where("user_id", $reciever_id)->first();
        if(!$notification) {
            $notification = Notification::create([
                "user_id" => $reciever_id,
                "message" => "[]",
                "isRead" => true
            ]);
        }

        // Updating the current notification associated to specific user

        $notifications = json_decode($notification->message);
        $notifications = [
            ...$notifications,
            [
                "id" => (string)str()->uuid(),
                "message" => $message,
                "isRead" => false,
                "type" => "new_task"
            ]
        ];
        if($sender_id) {
            $user = User::select("name")->find($sender_id);
            $notifications[count($notifications) - 1]["sender_name"] = $user->name;
        }
        $notification->update([
            "message" => json_encode($notifications),
            "isRead" => false
        ]);
    }
    public function storeMessage($sender_id, $key, $message, $task_id, $type = "new_task") {
        $sender = User::find($sender_id);
        
        $messageInstance = Message::where("message_id", $key)->first();
        $messages = json_decode($messageInstance->messages);
        $updatedMessages = [
            ...$messages,
            [
                "profile_pic" => $sender->profile->profile_picture,
                "sender" => $sender_id,
                "message" => $message,
                "name" => $sender->name,
                "type" => $type,
                "task_id" => $task_id
            ]
        ];
        $messageInstance->update(
            [
                "messages" => json_encode($updatedMessages)
            ]
        );
    }
    public function is_contact($user_id) {
        $is_contact = DB::table("contact_relationship")->where(function($query) use ($user_id) {
            $query->where("user_id_1", $user_id)
                    ->Where("user_id_2", auth()->user()->id);
        })->orWhere(function($query) use($user_id) {
            $query->where("user_id_1", auth()->user()->id)
                    ->Where("user_id_2", $user_id);
        })->first();
        return $is_contact;
    }
    public function createContact($user_id, $uuid) {
        DB::table("contact_relationship")->insert([
            "user_id_1" => $user_id,
            "user_id_2" => auth()->user()->id,
            "message_id" => $uuid 
        ]);

        DB::table("chat_messages")->insert([
            "message_id" => $uuid,
            "messages" => "[]"
        ]);
    }
    public function checkOrCreate($user_id, $uuid) {
        $is_contact = $this->is_contact($user_id);
        $message_id = "";
        if(!$is_contact) {
            $this->createContact($user_id, $uuid);
            $message_id = $uuid;
        } else {
            $message_id = $is_contact->message_id;
        }
        return $message_id;
    }
    public function store(User $user) {
        $user_id = $user->id;
        
        $validation = Validator::make(request()->all(), [
            "task_name" => "required|min:5|max:50",
            "file_extension" => "required",
            "task_description" => "required|min:25|max:255",
            "deadline" => "required"
        ]);

        if($validation->fails()) {
            return response()->json([ "status" => 0, "errors" => $validation->errors()]);
        }
        
        
        $uuid = (string)str()->uuid();
        $uuid = $this->checkOrCreate($user_id, $uuid);

        $task = Task::create([
            "user_id" => $user_id,
            "assigner_id" => auth()->user()->id,
            "name" => request()->get("task_name"),
            "file_id" => request()->get("file_extension"),
            "description" => request()->get("task_description"),
            "deadline" => request()->get("deadline")
        ]);

        // event(new NotificationEvent(auth()->user()->id, $user_id, "New Task", "new_task"));
        // event(new DispatchMessage(
        //         "You have recieved new task", 
        //         auth()->user()->id, $user_id, 
        //         "new_task", 
        //         request()->get("deadline"),
        //         $task->id
        //     )
        // );

        dispatch(new SendTaskJob($user_id, request()->get("deadline"), $task->id));

        $this->storeMessageNotification(auth()->user()->id, $user_id, "New Task");
        $this->storeMessage(auth()->user()->id, $uuid, "You have recieved new task", $task->id);

        return 1;
    }
    public function submit(Task $task) {
        $uploaded_file = request()->file("upload_file");
        $file_id = request()->get("file_id");

        $file = File::find($file_id);
        $extensions = json_decode($file->supported_extensions);
        $ext_in_str = implode(", ", $extensions);
        $extensions = array_map(function($extension) {
            return strtolower($extension);
        }, $extensions); 
        
        $is_extension_right = in_array(strtolower($uploaded_file->extension()), $extensions);
        if(!$is_extension_right) {
            return response()->json([ "status" => 0, "errors" => "File extension must be " . $ext_in_str ]);
        }

        $fileName = time() . $uploaded_file->getClientOriginalName();
        $uploaded_file->move(public_path('uploads/submissions'), $fileName);

        $task->update([
            "file" => $fileName,
            // "status" => "pending approval"
        ]);

        
        event(new NotificationEvent(auth()->user()->id, $task->assigner_id, "New Task", "submit_task"));
        event(new DispatchMessage(
                "You have recieved new task", 
                auth()->user()->id, $task->assigner_id, 
                "submit_task", 
                request()->get("deadline"),
                $task->id
            )
        );
        $user_id = $task->assigner_id;
                
        $uuid = $this->is_contact($task->assigner_id);
        $this->storeMessageNotification(auth()->user()->id, $task->assigner_id, "New Task");
        $this->storeMessage(auth()->user()->id, $uuid->message_id, "You have recieved new task", $task->id, "submit_task");

        return 1;
    }
    public function download(Task $task) {
        $file = public_path() . "/uploads/submissions/" . $task->file;
        return response()->download($file);
    }
}
