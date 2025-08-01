window.addEventListener('DOMContentLoaded', () => {
  // Create popup once
  const popup = document.createElement('div');
  popup.id = 'popup-message';
  popup.className = 'fixed bottom-6 right-6 text-white px-4 py-2 rounded shadow-md text-sm opacity-0 transition-opacity duration-300 z-50';
  document.body.appendChild(popup);

  function showPopup(message, isError = false) {
    popup.innerText = message;
    popup.classList.remove('opacity-0');
    popup.classList.add('opacity-100');
    popup.classList.remove('bg-green-600', 'bg-red-600');
    popup.classList.add(isError ? 'bg-red-600' : 'bg-green-600');

    setTimeout(() => {
      popup.classList.remove('opacity-100');
      popup.classList.add('opacity-0');
    }, 3000);
  }

  const cards = document.querySelectorAll('details');

  cards.forEach(card => {
    const info = card.querySelector('.bg-white');
    const button = info.querySelector('button');
    const slotParagraph = Array.from(info.querySelectorAll('p'))
      .find(p => p.textContent.includes('Available Slots:'));

    if (slotParagraph && button) {
      const match = slotParagraph.textContent.match(/Available Slots:\s*(\d+)/);
      const slots = match ? parseInt(match[1], 10) : 0;

      // Reset button styling
      button.classList.remove('bg-yellow-300', 'hover:bg-yellow-400', 'bg-gray-300', 'cursor-not-allowed');

      if (slots === 0) {
        // Visibly gray + still clickable
        button.classList.add('bg-gray-300', 'cursor-not-allowed');
        button.disabled = false;

        button.addEventListener('click', (e) => {
          e.preventDefault();
          showPopup('No slots available', true);
        });
      } else {
        button.classList.add('bg-yellow-300', 'hover:bg-yellow-400');
        button.disabled = false;

        button.addEventListener('click', (e) => {
          e.preventDefault();
          showPopup('Booking confirmed!', false);
        });
      }
    }
  });
});
