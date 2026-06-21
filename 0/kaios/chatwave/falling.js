// script.js

(function() {
  const LONG_PRESS_DURATION = 1000; // 3 seconds
  const TARGET_KEY = '5'; // Key to detect (e.key == '5')
  let pressTimer = null;
  let isLongPress = false;

  // Load saved option or default to '0' (off)
  let currentOption = localStorage.getItem('kaios_option') || '0';

  // Store user name if entered
  let userName = localStorage.getItem('kaios_name') || '';

  // Define emoji options
  const itemsOptions = {
    '1': '❤️', // Heart
    '2': '🌸', // Flower
    '3': '🌹', // Rose
    '4': '🩲', // Panty
    '5': '😘', // Kiss
    '6': '🎂', // Cake
    '7': '⭐',
    '8': '✨',
    '9': '🌟',
    '10': '🌈',
    '11': '💖',
    '12': '🌻',
    '13': '🍭',
    '14': '🎉',
    '15': '🎈',
    '16': '🎁',
    '17': '🎵',
    '18': '🎶',
    '19': '🎺',
    '20': '🎸',
  };

  // Create overlay for falling animations
  const overlay = document.createElement('div');
  overlay.style.position = 'fixed';
  overlay.style.top = 0;
  overlay.style.left = 0;
  overlay.style.width = '100%';
  overlay.style.height = '100%';
  overlay.style.pointerEvents = 'none';
  overlay.style.overflow = 'hidden';
  overlay.style.zIndex = 9999;
  document.body.appendChild(overlay);

  function handleKeyDown(e) {
    if (e.key === TARGET_KEY) {
      if (pressTimer === null) {
        isLongPress = false;
        pressTimer = setTimeout(() => {
          isLongPress = true;
          openMenu();
        }, LONG_PRESS_DURATION);
      }
    }
  }

  function handleKeyUp(e) {
    if (e.key === TARGET_KEY) {
      if (pressTimer !== null) {
        clearTimeout(pressTimer);
        pressTimer = null;
      }
    }
  }

  function openMenu() {
    const menuMsg = `
Select option:
0 - Off
00 - All
000 - Random
0000 - Enter Name
1-20 - Specific
Current: ${currentOption}
Enter choice:
`;
    const choice = prompt(menuMsg, currentOption);
    if (choice !== null) {
      if (choice === '0000') {
        // Ask for name
        const name = prompt('Enter your name:', userName);
        if (name !== null && name.trim() !== '') {
          userName = name.trim();
          localStorage.setItem('kaios_name', userName);
          currentOption = '0000';
          localStorage.setItem('kaios_option', currentOption);
        }
      } else if (['0', '00', '000'].includes(choice)) {
        currentOption = choice;
        localStorage.setItem('kaios_option', currentOption);
      } else {
        // Check if number 1-20
        const numChoice = parseInt(choice, 10);
        if (!isNaN(numChoice) && numChoice >= 1 && numChoice <= 20) {
          currentOption = choice;
          localStorage.setItem('kaios_option', currentOption);
        } else {
          alert('Invalid choice');
        }
      }
    }
  }

  function createFallingItem() {
    let emojiOrText = '';

    if (currentOption === '0') {
      // Off
      return;
    } else if (currentOption === '00') {
      // All options
      const keys = Object.keys(itemsOptions);
      const randKey = keys[Math.floor(Math.random() * keys.length)];
      emojiOrText = itemsOptions[randKey];
    } else if (currentOption === '000') {
      // Random emoji
      const keys = Object.keys(itemsOptions);
      const randKey = keys[Math.floor(Math.random() * keys.length)];
      emojiOrText = itemsOptions[randKey];
    } else if (currentOption === '0000') {
      // Show name as falling text
      if (userName !== '') {
        emojiOrText = userName;
      } else {
        // fallback to random emoji
        const keys = Object.keys(itemsOptions);
        const randKey = keys[Math.floor(Math.random() * keys.length)];
        emojiOrText = itemsOptions[randKey];
      }
    } else {
      // Specific number 1-20
      const num = parseInt(currentOption, 10);
      emojiOrText = itemsOptions[String(num)] || '✨';
    }

    // Create DOM element
    const item = document.createElement('div');
    item.textContent = emojiOrText;
    item.style.position = 'absolute';
    item.style.top = '-50px';
    item.style.fontSize = '24px';
    item.style.pointerEvents = 'none';

    // Random start position
    const startX = Math.random() * window.innerWidth;
    item.style.left = `${startX}px`;

    overlay.appendChild(item);

    // Animate
    const duration = 3000 + Math.random() * 2000; // 3-5 sec
    const endY = window.innerHeight + 50;
    const startTime = performance.now();

    function animate(currentTime) {
      const elapsed = currentTime - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const currentY = progress * endY;
      const sway = Math.sin(progress * Math.PI * 4) * 50; // sway
      item.style.top = `${currentY}px`;
      item.style.left = `${startX + sway}px`;
      if (progress < 1) {
        requestAnimationFrame(animate);
      } else {
        overlay.removeChild(item);
      }
    }
    requestAnimationFrame(animate);
  }

  // Start periodic falling
  let fallingInterval = null;
  function startFalling() {
    if (fallingInterval === null) {
      fallingInterval = setInterval(createFallingItem, 300);
    }
  }
  function stopFalling() {
    if (fallingInterval !== null) {
      clearInterval(fallingInterval);
      fallingInterval = null;
    }
  }

  document.addEventListener('keydown', handleKeyDown);
  document.addEventListener('keyup', handleKeyUp);

  startFalling();

})();