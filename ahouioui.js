var selectedItems = [];

const selecctarticle = document.getElementsByClassName("input-selection");

const selectedItemsBefore = document.querySelector("input[name='selectedItems']").value;



for (var i = 0; i < selecctarticle.length; i++) {
    const element = selecctarticle[i];
    element.addEventListener("change", (event) => {
        if(selectedItems.indexOf(element.value)==-1){
            selectedItems.push(element.value)
        }else{
            selectedItems.pop(element.value)
        }
    })
}

document.querySelector("#form-filtre").addEventListener("submit", function(event) {
    event.preventDefault();
    document.querySelector("input[name='selectedItems']").value += JSON.stringify(JSON.stringify(selectedItems));
    this.submit();
});


document.querySelector("#form-confirmation").addEventListener("submit", function(event) {
    event.preventDefault();
    let AddItems = document.querySelector("input[name='selectedItems']").value;
    document.querySelector("input[name='articles']").value = JSON.stringify(JSON.stringify(selectedItems+AddItems));
    this.submit();
});

function clearcache(){
    document.querySelector("input[name='selectedItems']").value = "";
}