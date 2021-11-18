function showHint(id) {
    let value1 = document.getElementById(id)
    str=value1;
    console.log("Key up"+str);
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() {
        if (this.readyState === 4 && this.status === 200) {
            let tab=this.responseText.split(',');
            console.log(tab);
            document.getElementById(id).innerHTML = "";
            for(let i=0; i<tab.length-1; i++){
                document.getElementById(id).innerHTML += '<option value="'+tab[i]+'">'+tab[i+1]+' - '+ tab[i]+'</option>';
                i++;
            }

        }
    };
    xmlhttp.open("GET", "PHP/search.php", true);
    xmlhttp.send();
}


function main() {
    console.log("start");
    showHint("ville1");
    showHint("ville2");
}
main();