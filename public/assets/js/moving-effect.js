const movingDiv = document.getElementById('login');

document.addEventListener('mousemove', (e) => {
    const cursorX = e.clientX;
    const cursorY = e.clientY;

    const divRect = movingDiv.getBoundingClientRect();
    const divCenterX = divRect.left + divRect.width / 2;
    const divCenterY = divRect.top + divRect.height / 2;

    const deltaX = cursorX - divCenterX;
    const deltaY = cursorY - divCenterY;

    // Adjust the transformation of the div based on cursor position
    const moveX = deltaX * 0.01;
    const moveY = deltaY * 0.01;

    movingDiv.style.transform = `translate(${moveX}px, ${moveY}px)`;
});

// Reset the div's position when the cursor leaves
movingDiv.addEventListener('mouseleave', () => {
    movingDiv.style.transform = 'translate(0, 0)';
});