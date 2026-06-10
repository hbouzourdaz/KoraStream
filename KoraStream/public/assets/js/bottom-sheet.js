/**
 * Android-style Bottom Sheet Controller
 */

function openBottomSheet(sheetId, backdropId) {
    const sheet = document.getElementById(sheetId);
    const backdrop = document.getElementById(backdropId);

    if (sheet && backdrop) {
        // Show backdrop
        backdrop.classList.remove('hidden');
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
        }, 10);

        // Slide sheet up
        sheet.classList.remove('translate-y-full');
    }
}

function closeBottomSheet(sheetId, backdropId) {
    const sheet = document.getElementById(sheetId);
    const backdrop = document.getElementById(backdropId);

    if (sheet && backdrop) {
        // Slide sheet down
        sheet.classList.add('translate-y-full');

        // Hide backdrop
        backdrop.classList.add('opacity-0');
        setTimeout(() => {
            backdrop.classList.add('hidden');
        }, 300);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Setup generic backdrop closes
    const bottomSheetBackdrops = document.querySelectorAll('.sheet-backdrop');
    bottomSheetBackdrops.forEach(backdrop => {
        backdrop.addEventListener('click', () => {
            const sheetId = backdrop.getAttribute('data-sheet-id');
            const backdropId = backdrop.id;
            closeBottomSheet(sheetId, backdropId);
        });
    });
});
