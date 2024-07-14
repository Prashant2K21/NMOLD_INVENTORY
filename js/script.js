var  sideBarIsopen = true;  
    var dashboardContentContainer =document.getElementsByClassName('dashboard_content_container')[0];

         toggleBtn.addEventListener( 'click', (event) => {
         event.preventDefault();

    if(sideBarIsopen){
    dashboard_slidebar.style.width='10%';
    dashboard_slidebar.style.transition='0.3s all';
    dashboardContentContainer.style.width='90%';
    dashboard_logo.style.fontSize='60px';
    userimage.style.width='60px';

    menuIcons = document.getElementsByClassName('menuText');
    for(var i=0;i<menuIcons.length;i++){
        menuIcons[i].style.display='none';
    }
    document.getElementsByClassName('dashboard_menu_lists')[0].style.textAlign='center';
    sideBarIsopen = false; // Update the value to false
}else{
     dashboard_slidebar.style.width='20%';
     dashboardContentContainer.style.width='80%';
    dashboard_logo.style.fontSize='80px';
    userimage.style.width='80px';

    menuIcons = document.getElementsByClassName('menuText');
    for(var i=0;i<menuIcons.length;i++){
        menuIcons[i].style.display='inline-block';
    }
    document.getElementsByClassName('dashboard_menu_lists')[0].style.textAlign='left';
    sideBarIsopen = true;
}
});



//Submenu show /hide function.
document.addEventListener('click',function(e){
    let clickedE1 = e.target;

    if(clickedE1.classList.contains('showHideSubMenu')){
        let subMenu = clickedE1.closest('li').querySelector('.subMenus');
        let mainMenuIcon = clickedE1.closest('li').querySelector('.mainMenuIconArrow');

//close all subMenus.


       let subMenus = document.querySelectorAll('.subMenus');
       subMenus.forEach((sub) =>{
        if (subMenu != sub) sub.style.display = 'none';
       });
       //call function to hide/show submenu.
       showHideSubMenu(subMenu,mainMenuIcon);
     }
});

//function - to show/hide submenu
  function showHideSubMenu(subMenu,mainMenuIcon){
    //check if there is submenu
    if(subMenu != null){
        if(subMenu.style.display === 'block') {
            subMenu.style.display = 'none';
            mainMenuIcon.classList.remove('fa-angle-down');
            mainMenuIcon.classList.add('fa-angle-left');
            
            
        }else {
            subMenu.style.display = 'block';
            mainMenuIcon.classList.remove('fa-angle-left');
            mainMenuIcon.classList.add('fa-angle-down');
        }
    }
  }

//Add / hide active class to menu
//Get the current page
//use selector to get the current menu or snmenu
//Add the active class

let pathArray = window.location.pathname.split('/');
let curFile = pathArray[pathArray.length - 1];

let curNav = document.querySelector('a[href="./'+ curFile+'"]');
curNav.classList.add('subMenuActive');

let mainNav = curNav.closest('li.liMainMenu');
mainNav.style.background = '#f685a1';

let subMenu = curNav.closest('.subMenus');
let mainMenuIcon = mainNav.querySelector('i.mainMenuIconArrow');


//call function to hide/show submenu.
showHideSubMenu(subMenu,mainMenuIcon);



