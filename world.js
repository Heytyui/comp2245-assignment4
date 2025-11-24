document.addEventListener("DOMContentLoaded", function () {
    let lookupBtn = document.getElementById("lookupCountry");
    let result_div = document.getElementById("result");

    lookupBtn.addEventListener("click", function (){
        let inputcountry = document.getElementById("country");
        let query = "";
        if (inputcountry && inputcountry.value.trim() !== ""){
            query = "?country=" + encodeURIComponent(inputcountry.value.trim());
        }
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "world.php" + query, true);

        xhr.onload = function () {
            if (xhr.status === 200){
                result_div.innerHTML = xhr.responseText;
            }
            else{
                result_div.innerHTML = "Error: " + xhr.status
            };

        };
        xhr.onerror = function (){
            result_div.innerHTML = "Request failed. Please try again. ";

        };

        xhr.send();
    });

});

document.getElementById("lookupCities").addEventListener("click", function(){
    const country = document.getElementById("country").value;
    if(country.trim() === ""){
        alert("Please enter the name of a country!!");
        return;
    }

    fetch(`world.php?country=${encodeURIComponent(country)}&lookup=cities`)
        .then(response => response.text())
        .then(data => {
            document.getElementById("result").innerHTML = data;
        })
        .catch(error => console.error("Error:", error));
});

                
            
        
    
