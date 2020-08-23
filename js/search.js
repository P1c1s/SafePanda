function search1() {

   var i;
   var title;
   var card;
   var txtValue;
   var input = document.getElementById("searchBar1").value.toUpperCase();
   var dim = document.getElementById("elementsNumber").value;

   for(i=0;i<dim;i++){

     card=document.getElementById("card"+i);
     title = document.getElementById("titleCard"+i);
     txtValue = title.textContent.toUpperCase()|| title.innerText.toUpperCase();

//   alert(input +" | "+txtValue);
     if(txtValue.toUpperCase().indexOf(input) > -1){
      card.style.display = "";
      }
     else card.style.display = "none";

   }

}

function search2() {

   var i;
   var title;
   var card;
   var txtValue;
   var input = document.getElementById("searchBar2").value.toUpperCase();
   var dim = document.getElementById("elementsNumber").value;

   for(i=0;i<dim;i++){

     card=document.getElementById("card"+i);
     title = document.getElementById("titleCard"+i);
     txtValue = title.textContent.toUpperCase()|| title.innerText.toUpperCase();

//   alert(input +" | "+txtValue);
     if(txtValue.toUpperCase().indexOf(input) > -1){
      card.style.display = "";
      }
     else card.style.display = "none";

   }

}
