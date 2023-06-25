let topButton = document.getElementById("button-up");

window.onscroll = function() {scrollFunction()};

function scrollFunction() {
  if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
    topButton.style.display = "block";
  } else {
    topButton.style.display = "none";
  }
}

function topFunction() {
  document.body.scrollTop = 0; // For Safari
  document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE and Opera
}

function hideAllCorouselElements(corouselContentElements){
  for (const element of corouselContentElements) {
      hideCorouselElement(element);
  }
}

function hideCorouselElement(element){
  element.style.display='none';
}

function showCorouselElement(element){
  element.style.display='flex';
}

let corousel = document.getElementById("carousel");
let corouselContentElements = [];
for (const child of corousel.children) {
  if (child.classList.contains("carousel-content")) {
    corouselContentElements.push(child);
  }
}
hideAllCorouselElements(corouselContentElements);
let currentCorouselElement = 0;
showCorouselElement(corouselContentElements[currentCorouselElement]);

function showNextCorouselElement(){
  hideAllCorouselElements(corouselContentElements);
  if(currentCorouselElement == (corouselContentElements.length - 1)) {
    currentCorouselElement = 0;
  } else {
    currentCorouselElement++;
  }
  showCorouselElement(corouselContentElements[currentCorouselElement]);
}

function showPreviousCorouselElement(){
  hideAllCorouselElements(corouselContentElements);
  if(currentCorouselElement == 0) {
    currentCorouselElement = corouselContentElements.length - 1;
  } else {
    currentCorouselElement--;
  }
  showCorouselElement(corouselContentElements[currentCorouselElement]);
}

let mobileMenu = document.getElementById("mobile-menu");
let mobileTopBar = document.getElementById("mobile-top-bar");
function openMenuFunction(){
  mobileMenu.style.visibility='visible';
  mobileTopBar.style.visibility='hidden';
}
function closeMenuFunction(){
  mobileMenu.style.visibility='hidden';
  mobileTopBar.style.visibility='visible';
}