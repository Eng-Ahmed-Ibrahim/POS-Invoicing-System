const tabsContainer = document.querySelector('.tabs-container');
let isDown = false;
let startX;
let scrollLeft;

// Mouse down event to start swipe
tabsContainer.addEventListener('mousedown', (e) => {
    isDown = true;
    tabsContainer.classList.add('active');
    startX = e.pageX - tabsContainer.offsetLeft;
    scrollLeft = tabsContainer.scrollLeft;
});

// Mouse leave event to stop swipe
tabsContainer.addEventListener('mouseleave', () => {
    isDown = false;
    tabsContainer.classList.remove('active');
});

// Mouse up event to stop swipe
tabsContainer.addEventListener('mouseup', () => {
    isDown = false;
    tabsContainer.classList.remove('active');
});

// Mouse move event to handle swipe
tabsContainer.addEventListener('mousemove', (e) => {
    if (!isDown) return;
    e.preventDefault();
    const x = e.pageX - tabsContainer.offsetLeft;
    const walk = (x - startX) * 2; // Adjust the scroll speed
    tabsContainer.scrollLeft = scrollLeft - walk;
});

// Handle touch events for mobile devices
tabsContainer.addEventListener('touchstart', (e) => {
    startX = e.touches[0].pageX - tabsContainer.offsetLeft;
    scrollLeft = tabsContainer.scrollLeft;
});

tabsContainer.addEventListener('touchmove', (e) => {
    const x = e.touches[0].pageX - tabsContainer.offsetLeft;
    const walk = (x - startX) * 2; // Adjust the scroll speed
    tabsContainer.scrollLeft = scrollLeft - walk;
});
