// function checkVertical() {
//     var verticalVal = document.getElementById("layout-vertical").value;
//     // Save the value in local storage
//     localStorage.setItem('menuPosition', verticalVal);

// }

// function checkHorizontal(){
// 	var horizontalVal = document.getElementById("layout-horizontal").value;
// 	// Save the value in local storage
// 	localStorage.setItem('menuPostision', horizontalVal);
 
// }

// document.addEventListener("DOMContentLoaded", () => {
//     var getMenuPosision = localStorage.getItem('menuPostision');
//     // Append the value to the body element
//     if(getMenuPosision){
//       document.body.setAttribute('data-layout', verticalVal);
//     }    
// });

// document.addEventListener('DOMContentLoaded', function () {
//     // Check if menuposition is stored in localStorage
//     if (localStorage.getItem('menuPostision')) {
//         // Get the menuposition value from localStorage
//         var menuPosition = localStorage.getItem('menuPostision');

//         // Set the data-layout attribute based on the menuposition value
//         if (menuPosition === 'vertical' || menuPosition === 'horizontal') {
//             document.body.setAttribute('data-layout', menuPosition);
//         }
//     }
// });



function moonLayout() {
    var moonToolBarVal = document.getElementById("layout-mode-dark").value;
    // Save the value in local storage
    localStorage.setItem('toolBarMode', moonToolBarVal);
    location.reload();  
}

function lightLayout() {
    var lightToolBarVal = document.getElementById("layout-mode-light").value;
    // Save the value in local storage
    localStorage.setItem('toolBarMode', lightToolBarVal);
    location.reload();     
}

document.addEventListener('DOMContentLoaded', function () {
    // Check if menuposition is stored in localStorage
    if (localStorage.getItem('toolBarMode')) {
        // Get the menuposition value from localStorage
        var toolBarMode = localStorage.getItem('toolBarMode');

        document.body.setAttribute('data-topbar', toolBarMode);
        document.body.setAttribute('data-layout-mode', toolBarMode);

        if(toolBarMode=='dark'){
          document.getElementById("layout-mode-dark").checked = true;
        }

        if(toolBarMode=='light'){
          document.getElementById("layout-mode-light").checked = true;
        }
    }
});