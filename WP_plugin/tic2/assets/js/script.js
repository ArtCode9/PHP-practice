/* function showModal() {
   document.getElementById('popup').style.display = 'block';
}

function hideModal() {
   document.getElementById('popup').style.display = 'none';
}

 */

// Show modal function
function showModal(popupId) {
   // Create overlay if it doesn't exist
   if (!document.getElementById('modal-overlay')) {
       const overlay = document.createElement('div');
       overlay.id = 'modal-overlay';
       overlay.className = 'overlay';
       overlay.onclick = function() {
           hideModal(popupId);
       };
       document.body.appendChild(overlay);
   }
   
   document.getElementById('modal-overlay').style.display = 'block';
   document.getElementById(popupId).style.display = 'block';
}

// Hide modal function
function hideModal(popupId) {
   document.getElementById('modal-overlay').style.display = 'none';
   document.getElementById(popupId).style.display = 'none';
}