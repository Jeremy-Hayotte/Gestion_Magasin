
var url = 'http://localhost/getdata.php';
var selectedItems = [];
var filterCategorie = '';
var lesTrucsCheck = [];
var selecttablerows=[]

const selecctarticle = document.getElementsByClassName("input-selection");
const selectedItemsBefore = document.querySelector("input[name='selectedItems']").value;


function tabcreate() {
    console.log(filterCategorie);
    if (filterCategorie != '') {
        url = url + "?categorie="+filterCategorie;
    }
    fetch(url)
        .then(response => response.json())
        .then(data => {
    // Récupération de l'élément HTML pour afficher le tableau
    const tableBody = document.getElementById('table-body');

    // Création de chaque ligne du tableau avec les données JSON
    data.forEach(article => {
      const row = document.createElement('tr');
      const CODESAP = document.createElement('td');
      const CODEPOLE = document.createElement('td');
      const DESCRIPTION = document.createElement('td');
      const UNITE_DE_MESURE = document.createElement('td');
      const CATEGORIE = document.createElement('td');
      const selection = document.createElement('td');
      const checkbox = document.createElement('input');
      checkbox.type = 'checkbox';
      checkbox.value = article.id;
      checkbox.classList.add("checkbox")

      CODESAP.innerText = article.CODESAP;
      CODEPOLE.innerText = article.CODEPOLE;
      DESCRIPTION.innerText = article.Description;
      UNITE_DE_MESURE.innerText = article.Unitédemesure;
      CATEGORIE.innerText = article.Categorie

      row.classList.add('mabelle')
      row.appendChild(CODESAP);
      row.appendChild(CODEPOLE);
      row.appendChild(DESCRIPTION);
      row.appendChild(UNITE_DE_MESURE);
      row.appendChild(CATEGORIE);
      row.appendChild(checkbox);

      tableBody.appendChild(row);
    });

    for (let index = 0; index < lesTrucsCheck.length; index++) {
        const element = lesTrucsCheck[index];
        tableBody.appendChild(element);
    }
    setEvent();
  })
  .catch(error => {
    // Gérer les erreurs de récupération
    console.error('Une erreur s\'est produite:', error);
  });
}

function clearTable() {
    document.getElementById('table-body').innerHTML = '';
}

// Ajoute ou enlève l'élèment sélectionner
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


// Executer quand le form filtre est envoyé
document.querySelector("#form-filtre").addEventListener("submit", function(event) {
    event.preventDefault();
    selecttablerows = document.getElementsByClassName("jeleveux");
    clearTable()
    filterCategorie = document.getElementById('Categorie').value || '';
    for (let index = 0; index < selecttablerows.length; index++) {
        const element = selecttablerows[index];
        document.getElementById('table-body').appendChild(element);
    }
    tabcreate();
});

// Pareil mais pour le form valider
document.querySelector("#form-confirmation").addEventListener("submit", function(event) {
    event.preventDefault();
    let AddItems = document.querySelector("input[name='selectedItems']").value;
    // Dans le form valider
    document.querySelector("input[name='articles']").value = JSON.stringify(JSON.stringify(selectedItems+AddItems));
    this.submit();
});




function setEvent() {
    // evenement qui s'execute sur chaque ligne -> quand la checkbox change on ajoute une class
    let elements = document.getElementsByClassName('mabelle');
    console.log("dans setevent" + elements.length)
    for (let index = 0; index < elements.length; index++) {
        const element = elements[index];
        let childrenList = element.children;
        for (let index = 0; index < childrenList.length; index++) {
            const child = childrenList[index];
            if (child.getAttribute("class") == 'checkbox') {
                console.log("2")
                child.addEventListener('change', () => {
                    console.log("3")
                    if(lesTrucsCheck.indexOf(element) == -1){
                        element.classList.add('jeleveux');
                        lesTrucsCheck.push(element);
                        console.log("4")
                    }else{
                        element.classList.remove('jeleveux');
                        lesTrucsCheck.pop(element);
                        console.log("5")
                    }
                })
            }
        }
    }
}

tabcreate();



