// sidepanel.js
const togglePanelBtn = document.getElementById('togglePanelBtn');
const sidePanel = document.querySelector('.side-panel');

togglePanelBtn.addEventListener('click', () => {
    sidePanel.classList.toggle('active');
});

const closePanelBtn = document.getElementById('closePanelBtn');

closePanelBtn.addEventListener('click', () => {
    sidePanel.classList.remove('active');
});
