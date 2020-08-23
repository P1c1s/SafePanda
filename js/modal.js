function modify(num){

   /* BUTTONS */
   document.getElementById("modify"+num).style.display="none";
   document.getElementById("cancel"+num).style.display="";
   document.getElementById("update"+num).style.display="";
   document.getElementById("delete"+num).style.display="";
   document.getElementById("show"+num).style.display="none";
   document.getElementById("hide"+num).style.display="none";

   /* PASSWORD FIELDS */
   document.getElementById("password"+num).style.display="";
   document.getElementById("password*"+num).style.display="none";
   document.getElementById("eye"+num).style.display="none";

   /* OTHER FIELDS */
   document.getElementById("pinRow"+num).style.display="";
   document.getElementById("urlRow"+num).style.display="";
   document.getElementById("tagRow"+num).style.display="";
   document.getElementById("iconRow"+num).style.display="";
   document.getElementById("pinRow"+num).style.display="";
   document.getElementById("urlRow"+num).style.display="";
   document.getElementById("colorRow"+num).style.display="";
   document.getElementById("notesRow"+num).style.display="";

   /* COLOR*/
  // document.getElementById("radioColor").style.display="";
  // document.getElementById("color"+num).style.display="none";

   /* FIELDS CONVERTION  */
   var text = document.getElementById('title'+num);
   var field = document.createElement("input");
   field.setAttribute("id", "title"+num);
   field.setAttribute("name", "title");
   field.setAttribute("class", "form-control form-control-user");
   field.setAttribute("value", text.innerHTML);
   text.parentNode.insertBefore(field, text);
   text.parentNode.removeChild(text);

   var text = document.getElementById('username'+num);
   var field = document.createElement("input");
   field.setAttribute("id", "username"+num);
   field.setAttribute("name", "username");
   field.setAttribute("class", "form-control form-control-user");
   field.setAttribute("value", text.innerHTML);
   text.parentNode.insertBefore(field, text);
   text.parentNode.removeChild(text);

   var text = document.getElementById('password'+num);
   var field = document.createElement("input");
   field.setAttribute("id", "password"+num);
   field.setAttribute("name", "password");
   field.setAttribute("class", "form-control form-control-user");
   field.setAttribute("value", text.innerHTML);
   text.parentNode.insertBefore(field, text);
   text.parentNode.removeChild(text);

   var text = document.getElementById('pin'+num);
   var field = document.createElement("input");
   field.setAttribute("id", "pin"+num);
   field.setAttribute("name", "pin");
   field.setAttribute("class", "form-control form-control-user");
   if(text.innerHTML != "/")
      field.setAttribute("value", text.innerHTML);
   text.parentNode.insertBefore(field, text);
   text.parentNode.removeChild(text);

   var text = document.getElementById('url'+num);
   var field = document.createElement("input");
   field.setAttribute("id", "url"+num);
   field.setAttribute("name", "url");
   field.setAttribute("class", "form-control form-control-user");
   if(text.innerHTML != "/")
      field.setAttribute("value", text.innerHTML);
   text.parentNode.insertBefore(field, text);
   text.parentNode.removeChild(text);

   var text = document.getElementById('tag'+num);
   var field = document.createElement("input");
   field.setAttribute("id", "tag"+num);
   field.setAttribute("name", "tag");
   field.setAttribute("class", "form-control form-control-user");
   if(text.innerHTML != "/")
      field.setAttribute("value", text.innerHTML);
   text.parentNode.insertBefore(field, text);
   text.parentNode.removeChild(text);

   var text = document.getElementById('icon'+num);
   var field = document.createElement("input");
   field.setAttribute("id", "icon"+num);
   field.setAttribute("name", "icon");
   field.setAttribute("class", "form-control form-control-user");
   if(text.innerHTML != "/")
      field.setAttribute("value", text.innerHTML);
   text.parentNode.insertBefore(field, text);
   text.parentNode.removeChild(text);



   document.getElementById("color"+num).style.display="none";
   var color = document.getElementById("color"+num).innerHTML;

   var node = document.createElement("div");
   node.setAttribute("id","radio"+num);
   node.setAttribute("class","form-group row");
   document.getElementById("colorRow"+num).appendChild(node);

   var div = document.createElement("div");
   div.setAttribute("id","orange"+num);
   div.setAttribute("class","col-sm-3 mb-3 mb-sm-0");
   document.getElementById("radio"+num).appendChild(div);

   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","orange");
   node.setAttribute("type","radio");
   if(color == "arancione")
      node.setAttribute("checked","checked");
   document.getElementById("orange"+num).appendChild(node);
   var text = document.createTextNode("arancione");
   document.getElementById("orange"+num).appendChild(text);

   var div = document.createElement("div");
   div.setAttribute("id","primary"+num);
   div.setAttribute("class","col-sm-3 mb-3 mb-sm-0");
   document.getElementById("radio"+num).appendChild(div);

   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","primary");
   node.setAttribute("type","radio");
   if(color == "arancione")
      node.setAttribute("checked","checked");
   document.getElementById("primary"+num).appendChild(node);
   var text = document.createTextNode("blu");
   document.getElementById("primary"+num).appendChild(text);

   var div = document.createElement("div");
   div.setAttribute("id","info"+num);
   div.setAttribute("class","col-sm-3 mb-3 mb-sm-0");
   document.getElementById("radio"+num).appendChild(div);

   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","info");
   node.setAttribute("type","radio");
   if(color == "ciao")
      node.setAttribute("checked","checked");
   document.getElementById("info"+num).appendChild(node);
   var text = document.createTextNode("ciano");
   document.getElementById("info"+num).appendChild(text);

   var div = document.createElement("div");
   div.setAttribute("id","warning"+num);
   div.setAttribute("class","col-sm-3 mb-3 mb-sm-0");
   document.getElementById("radio"+num).appendChild(div);

   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","warning");
   node.setAttribute("type","radio");
   if(color == "giallo")
      node.setAttribute("checked","checked");
   document.getElementById("warning"+num).appendChild(node);
   var text = document.createTextNode("giallo");
   document.getElementById("warning"+num).appendChild(text);

   var div = document.createElement("div");
   div.setAttribute("id","secondary"+num);
   div.setAttribute("class","col-sm-3 mb-3 mb-sm-0");
   document.getElementById("radio"+num).appendChild(div);

   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","secondary");
   node.setAttribute("type","radio");
   if(color == "grigio")
      node.setAttribute("checked","checked");
   document.getElementById("secondary"+num).appendChild(node);
   var text = document.createTextNode("grigio");
   document.getElementById("secondary"+num).appendChild(text);

   var div = document.createElement("div");
   div.setAttribute("id","dark"+num);
   div.setAttribute("class","col-sm-3 mb-3 mb-sm-0");
   document.getElementById("radio"+num).appendChild(div);

   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","dark");
   node.setAttribute("type","radio");
   if(color == "nero")
      node.setAttribute("checked","checked");
   document.getElementById("dark"+num).appendChild(node);
   var text = document.createTextNode("nero");
   document.getElementById("dark"+num).appendChild(text);

   var div = document.createElement("div");
   div.setAttribute("id","pink"+num);
   div.setAttribute("class","col-sm-3 mb-3 mb-sm-0");
   document.getElementById("radio"+num).appendChild(div);

   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","pink");
   node.setAttribute("type","radio");
   if(color == "rosa")
      node.setAttribute("checked","checked");
   document.getElementById("pink"+num).appendChild(node);
   var text = document.createTextNode("rosa");
   document.getElementById("pink"+num).appendChild(text);

   var div = document.createElement("div");
   div.setAttribute("id","danger"+num);
   div.setAttribute("class","col-sm-3 mb-3 mb-sm-0");
   document.getElementById("radio"+num).appendChild(div);

   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","danger");
   node.setAttribute("type","radio");
   if(color == "rosso")
      node.setAttribute("checked","checked");
   document.getElementById("danger"+num).appendChild(node);
   var text = document.createTextNode("rosso");
   document.getElementById("danger"+num).appendChild(text);

   var div = document.createElement("div");
   div.setAttribute("id","success"+num);
   div.setAttribute("class","col-sm-3 mb-3 mb-sm-0");
   document.getElementById("radio"+num).appendChild(div);

   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","success");
   node.setAttribute("type","radio");
   if(color == "verde")
      node.setAttribute("checked","checked");
   document.getElementById("success"+num).appendChild(node);
   var text = document.createTextNode("verde");
   document.getElementById("success"+num).appendChild(text);

   var div = document.createElement("div");
   div.setAttribute("id","purple"+num);
   div.setAttribute("class","col-sm-3 mb-3 mb-sm-0");
   document.getElementById("radio"+num).appendChild(div);

   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","purple");
   node.setAttribute("type","radio");
   if(color == "viola")
      node.setAttribute("checked","checked");
   document.getElementById("purple"+num).appendChild(node);
   var text = document.createTextNode("viola");
   document.getElementById("purple"+num).appendChild(text);

/*
   var div = document.createElement("div");
   div.setAttribute("id","primary"+num);
   div.setAttribute("class","col-sm-3 mb-3 mb-sm-0");
   document.getElementById("radio"+num).appendChild(div);

   var div = document.createElement("div");
   div.setAttribute("id","orange"+num);
   div.setAttribute("class","col-sm-3 mb-3 mb-sm-0");
   document.getElementById("radio"+num).appendChild(div);

   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","primary");
   node.setAttribute("type","radio");
   if(color == "blu")
      node.setAttribute("checked","checked");
   document.getElementById("primary"+num).appendChild(node);
   var text = document.createTextNode("blu");
   document.getElementById("primary"+num).appendChild(text);




/*
   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","primary");
   node.setAttribute("type","radio");
   if(color == "blu")
      node.setAttribute("checked","checked");
   document.getElementById("radio"+num).appendChild(node);
   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","info");
   node.setAttribute("type","radio");
   if(color == "ciano")
      node.setAttribute("checked","checked");
   document.getElementById("radio"+num).appendChild(node);
   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","warning");
   node.setAttribute("type","radio");
   if(color == "giallo")
      node.setAttribute("checked","checked");
   document.getElementById("radio"+num).appendChild(node);
   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","secondary");
   node.setAttribute("type","radio");
   if(color == "grigio")
      node.setAttribute("checked","checked");
   document.getElementById("radio"+num).appendChild(node);
   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","dark");
   node.setAttribute("type","radio");
   if(color == "nero")
      node.setAttribute("checked","checked");
   document.getElementById("radio"+num).appendChild(node);
   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","pink");
   node.setAttribute("type","radio");
   if(color == "rosa")
      node.setAttribute("checked","checked");
   document.getElementById("radio"+num).appendChild(node);
   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","danger");
   node.setAttribute("type","radio");
   if(color == "rosso")
      node.setAttribute("checked","checked");
   document.getElementById("radio"+num).appendChild(node);
   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","success");
   node.setAttribute("type","radio");
   if(color == "verde")
      node.setAttribute("checked","checked");
   document.getElementById("radio"+num).appendChild(node);
   var node = document.createElement("input");
   node.setAttribute("type","radio");
   node.setAttribute("name","color");
   node.setAttribute("value","purple");
   node.setAttribute("type","radio");
   if(color == "viola")
      node.setAttribute("checked","checked");
   document.getElementById("radio"+num).appendChild(node);
*/
   var text = document.getElementById('notes'+num);
   var field = document.createElement("textarea");
   field.setAttribute("id", "notes"+num);
   field.setAttribute("name", "notes");
   field.setAttribute("class", "form-control form-control-user");
   if(text.innerHTML != "/")
      field.innerHTML = text.innerHTML;
   text.parentNode.insertBefore(field, text);
   text.parentNode.removeChild(text);

}

function cancel(num){

   /* BUTTONS */
   document.getElementById("modify"+num).style.display="";
   document.getElementById("cancel"+num).style.display="none";
   document.getElementById("update"+num).style.display="none";
   document.getElementById("delete"+num).style.display="none";
   document.getElementById("show"+num).style.display="";
   document.getElementById("hide"+num).style.display="none";

   /* OTHER FIELDS */
   document.getElementById("pinRow"+num).style.display="none";
   document.getElementById("urlRow"+num).style.display="none";
   document.getElementById("tagRow"+num).style.display="none";
   document.getElementById("iconRow"+num).style.display="none";
   document.getElementById("colorRow"+num).style.display="none";
   document.getElementById("notesRow"+num).style.display="none";

   var field = document.getElementById('title'+num);
   var text = document.createElement("h2");
   text.setAttribute("id", "title"+num);
   text.setAttribute("class", "h3 font-weight-bold text-primary text-uppercase mb-1");
   text.innerHTML=field.value;
   field.parentNode.insertBefore(text, field);
   field.parentNode.removeChild(field);

   var field = document.getElementById('username'+num);
   var text = document.createElement("h3");
   text.setAttribute("id", "username"+num);
   text.innerHTML=field.value;
   field.parentNode.insertBefore(text, field);
   field.parentNode.removeChild(field);

   var field = document.getElementById('password'+num);
   var text = document.createElement("h3");
   text.setAttribute("id", "password"+num);
   text.innerHTML=field.value;
   field.parentNode.insertBefore(text, field);
   field.parentNode.removeChild(field);

   var field = document.getElementById('pin'+num);
   var text = document.createElement("h5");
   text.setAttribute("id", "pin"+num);
   if(field.innerHTML != "")
      text.innerHTML=field.value;
   else
      text.innerHTML="/";
   field.parentNode.insertBefore(text, field);
   field.parentNode.removeChild(field);

   var field = document.getElementById('url'+num);
   var text = document.createElement("h5");
   text.setAttribute("id", "url"+num);
   if(field.innerHTML != "")
      text.innerHTML=field.value;
   else
      text.innerHTML="/";
   field.parentNode.insertBefore(text, field);
   field.parentNode.removeChild(field);

   var field = document.getElementById('tag'+num);
   var text = document.createElement("h5");
   text.setAttribute("id", "tag"+num);
   if(field.innerHTML != "")
      text.innerHTML=field.value;
   else
      text.innerHTML="/";
   field.parentNode.insertBefore(text, field);
   field.parentNode.removeChild(field);

   var field = document.getElementById('icon'+num);
   var text = document.createElement("h5");
   text.setAttribute("id", "icon"+num);
   if(field.innerHTML != "")
      text.innerHTML=field.value;
   else
      text.innerHTML="/";
   field.parentNode.insertBefore(text, field);
   field.parentNode.removeChild(field);

/*
   document.getElementById("color"+num).style.display="";
   var colorValue = $("input[name='color']:checked").val();
   if(colorValue == "primary")
      colorValue="blu";
   else
      if(colorValue == "success")
         colorValue="verde";
      else
         if(colorValue == "danger")
            colorValue="rosso";
         else
            if(colorValue == "info")
               colorValue="ciano";
            else
               if(colorValue == "warning")
                  colorValue="giallo";
               else
                  if(colorValue == "secondary")
                     colorValue="grigio";
                  else
                     if(colorValue == "dark")
                        colorValue="nero";
                      else
                         colorValue="/";




   var field = document.getElementById("color"+num);
   var text = document.createElement("h5");
   text.setAttribute("id", "color"+num);
   text.innerHTML=colorValue;
   field.parentNode.insertBefore(text, field);
   field.parentNode.removeChild(field);
*/

  var node = document.getElementById("radio"+num);
  node.parentNode.removeChild(node);

   var field = document.getElementById('notes'+num);
   var text = document.createElement("h5");
   text.setAttribute("id", "notes"+num);
   if(field.innerHTML != "")
      text.innerHTML=field.value;
   else
      text.innerHTML="/";
   field.parentNode.insertBefore(text, field);
   field.parentNode.removeChild(field);

   /* PASSWORD FIELDS */
   document.getElementById("password"+num).style.display="none";
   document.getElementById("password*"+num).style.display="";
   document.getElementById("eye"+num).style.display="";
}

function closeModal(num){

   document.getElementById("password"+num).style.display="none";
   document.getElementById("password*"+num).style.display="";

   if(document.getElementById("urlRow"+num).style.display == "" && document.getElementById("url"+num).tagName == "H5")

     hide(num);

   else

      if(document.getElementById("urlRow"+num).style.display == "" && document.getElementById("url"+num).tagName == "INPUT")

         cancel(num);

}

function show(num){

  /* OTHER FIELDS */
   document.getElementById("pinRow"+num).style.display="";
   document.getElementById("urlRow"+num).style.display="";
   document.getElementById("tagRow"+num).style.display="";
   document.getElementById("iconRow"+num).style.display="";
   document.getElementById("pinRow"+num).style.display="";
   document.getElementById("urlRow"+num).style.display="";
   document.getElementById("colorRow"+num).style.display="";
   document.getElementById("notesRow"+num).style.display="";

   document.getElementById("show"+num).style.display="none";
   document.getElementById("hide"+num).style.display="";

}

function hide(num){

  /* OTHER FIELDS */
   document.getElementById("pinRow"+num).style.display="none";
   document.getElementById("urlRow"+num).style.display="none";
   document.getElementById("tagRow"+num).style.display="none";
   document.getElementById("iconRow"+num).style.display="none";
   document.getElementById("pinRow"+num).style.display="none";
   document.getElementById("urlRow"+num).style.display="none";
   document.getElementById("colorRow"+num).style.display="none";
   document.getElementById("notesRow"+num).style.display="none";

   document.getElementById("hide"+num).style.display="none";
   document.getElementById("show"+num).style.display="";

}


//It' use for the atlernator condition
var counter=0;


function showPassword(num){

   //Alternator about show and hidden the password
   if(counter==0){
      document.getElementById("password"+num).style.display="";
      document.getElementById("password*"+num).style.display="none";
      counter=1;
   }
   else{
      document.getElementById("password"+num).style.display="none";
      document.getElementById("password*"+num).style.display="";
      counter=0;
   }
}
