/* function showModal() {
   document.getElementById('popup').style.display = 'block';
}

function hideModal() {
   document.getElementById('popup').style.display = 'none';
}
 */

/* 
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
} */


   function showModal(ticketId) {
      document.getElementById("popup-overlay-" + ticketId).style.display = "block";
      document.getElementById("popup-" + ticketId).style.display = "block";
  }
  
  function hideModal(ticketId) {
      document.getElementById("popup-overlay-" + ticketId).style.display = "none";
      document.getElementById("popup-" + ticketId).style.display = "none";
  }
  

//   ========================================
jQuery(document).ready(function($) {
   // When showing a ticket popup
   function showModal(ticketId) {
       // Show the modal
       document.getElementById("popup-overlay-" + ticketId).style.display = "block";
       document.getElementById("popup-" + ticketId).style.display = "block";
       
       // Mark as viewed via AJAX
       $.ajax({
           url: ajaxurl,
           type: 'POST',
           data: {
               action: 'mark_ticket_viewed',
               ticket_id: ticketId,
               nonce: ticket_view_nonce // You'll need to localize this
           },
           success: function(response) {
               if (response.success) {
                   // Update the notification count
                   updateNotificationCount();
               }
           }
       });
   }
   
   // Function to update notification count
   function updateNotificationCount() {
       $.get(ajaxurl, {
           action: 'get_new_tickets_count'
       }, function(response) {
           if (response.success) {
               $('.toplevel_page_support-tickets .plugin-count').text(response.count);
               if (response.count == 0) {
                   $('.toplevel_page_support-tickets .update-plugins').hide();
               }
           }
       });
   }
});


