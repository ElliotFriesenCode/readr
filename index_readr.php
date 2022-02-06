<?php
if (isset($_POST["numA"])){
    addClick();
}
function addClick(){
    
require 'init_readr.php';

$countQuery = $db->prepare("
SELECT id, site_visits
FROM information
");
$countQuery->execute();
$clicks = $countQuery->rowCount() ? $countQuery : [];
$clickCount = 0;
foreach($clicks as $click){
    $clickCount = $click['site_visits'];
}
$updateQuery = $db->prepare("
UPDATE information
SET site_visits = :site_visits
WHERE id = :id
");
$updateQuery->execute([ 
    'id' => 0,
    'site_visits' => $clickCount + 1
]);
}
?>
<html>
<head>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Comforter&family=Raleway:wght@200&display=swap" rel="stylesheet">
<link rel="stylesheet" href="styles_readr.css">
</head>
<body>
<div class="corner">
    <h3 class="header">Readr</h3>
    </div>
    <div class="center">
    <h3 class="description">1. Copy and paste. 2. Choose a word per minute. 3. Generate</h3>
    </div>
<form id="ninja" method="post" style="display:none;">
  <input type="hidden" id="numA" name="numA"/>
  
</form>
<div class="center">
    <div class="d">
    <input type="text-box" name="stuff" placeholder="Paste Text Here" class="paste">
    <input type="text-box" class="wpm" placeholder="wpm" name="wpm">
  
    <button type="button" class="buttons" onclick="getVal();">Generate</button>
    <button type="button" class="buttons" onclick="setTime();">Pause</button>
    <button type="button" class="buttons" onclick="Clear();">Clear</button>
    <select class="options"name="cars" id="cars">
 
  <option class="o" value="new">Single</option>
  <option class="o" value="original">Paragraph</option>
  
</select>
  
    </div>
    </div>
    <div class="hey_holder">
           
           </div> 
    <div  class="yo">

    </div>
    <p style="background-color: #FFFF00" id="output"></p>
     <script>
        
        if(localStorage.getItem('isParagraph') == null){
            localStorage.setItem('isParagraph', 'zero');
        }
         if(localStorage.getItem('dataaa') == null){
             localStorage.setItem('dataaa', '[]');
         }
         if(localStorage.getItem('wpmm') == null){
             localStorage.setItem('wpmm', 0);
         }
        let wpm = localStorage.getItem('wpmm');
        let isParagraph = localStorage.getItem('isParagraph');
      
                if(localStorage.getItem('isParagraph') == 'zero'){

                
                document.getElementsByClassName("options")[0].value = 'original';

                }
                else{ 
                    document.getElementsByClassName("options")[0].value = 'new';
                }
            
         
        let paused = false;
        let currentPos = 0;
        function setTime(){
            if(paused == false){
            wpm = 1000000;
            paused = true;
            }
            else{
                wpm =  localStorage.getItem('wpmm');
                paused = false;
                main(currentPos);
            }
        }
       let words = [];
       if(localStorage.getItem('dataaa') != null){
        words = JSON.parse(localStorage.getItem('dataaa'));
        main(0);
       }
       
       function Clear(){
        localStorage.setItem('dataaa', '[]');
        location.reload();
       }
        function getVal(){
        let nowVal = document.getElementsByClassName("options")[0].value;
       
            if(nowVal === "original"){

            
             localStorage.setItem('isParagraph', 'zero');
                 }
            else{
               
             localStorage.setItem('isParagraph', 'one');
                 }
         
          
         let s = document.getElementsByName("stuff")[0].value;
         let w = 60 / document.getElementsByName("wpm")[0].value * 1000;
         localStorage.setItem('wpmm', w)
         
         let x = 0;
         for(let r = 0; r < s.length; r++){
            if(s.charAt(r) == " "){
             words.push(s.substring(x, r));
             x = r;
            }
         }
         words.push(s.substring(x));
        
     
         localStorage.setItem('dataaa', JSON.stringify(words));
         document.getElementById("numA").value = "1";
         document.getElementById("ninja").submit();
        
      //   main(0);
        
        
        }  
    function timer(ms) { return new Promise(res => setTimeout(res, ms)); }
        async function wait(value){
            await timer(wpm);
            currentPos = value;
        }
    async function main(val) {
     //   let isP = document.getElementsByClassName("options")[0].value;
        if(localStorage.getItem('isParagraph') == 'one'){
            const d = document.querySelector(".hey_holder");
                 const p = document.createElement("P");
                 p.textContent = '';
                 p.style.background = '';
                 p.classList.add("hey");
                 d.appendChild(p);  
                
            for(let x = val; x < words.length; x++){      
              document.getElementsByClassName("hey")[0].textContent = words[x];
            
           await wait(x + 1);
             }
        }
        else{
            if(val == 0){
              for(let i = 0; i < words.length; i++){ 
                 const d = document.querySelector(".yo");
                 const p = document.createElement("P");
                 p.textContent = words[i];
                 p.style.background = '';
                 p.classList.add(i);
                    d.appendChild(p);  
                }
           }
               for(let x = val; x < words.length; x++){      
                document.getElementsByClassName(x.toString())[0].style.backgroundColor = "#CEC6D5";
                  document.getElementsByClassName(x.toString())[0].style.color = "black";
        
                  if(x > 0){
                     document.getElementsByClassName((x-1).toString())[0].style.backgroundColor = "";
                      document.getElementsByClassName((x-1).toString())[0].style.color = "black";
           
                 }
               await wait(x + 1);
             }
        }
       
    }
    </script>
</body>
</html>

