export const truncateString = (limit, string) => {
    const stringLimit = limit;
    let recentMessage = string;
    let lastSpaceOccured = stringLimit;
    const recentMessageDisplay = string.substring(0, stringLimit);
    if(recentMessage.length >= stringLimit) {
        lastSpaceOccured = recentMessageDisplay.lastIndexOf(" ");
    }
    return recentMessageDisplay.substring(0, lastSpaceOccured) + `${lastSpaceOccured > stringLimit ? "..." : ""}`
}
