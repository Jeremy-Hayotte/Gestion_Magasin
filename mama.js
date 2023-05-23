
var selectedItems = [];
var filterCategorie = '';

const selecctarticle = document.getElementsByClassName("input-selection");
const selectedItemsBefore = document.querySelector("input[name='selectedItems']").value;


function tabcreate() {
    let url = 'http://localhost/getdata.php';
    if (filterCategorie != '') {
        url += "?categorie="+filterCategorie;
    }
    console.log(url);
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

      row.appendChild(CODESAP);
      row.appendChild(CODEPOLE);
      row.appendChild(DESCRIPTION);
      row.appendChild(UNITE_DE_MESURE);
      row.appendChild(CATEGORIE);
      row.appendChild(checkbox);

      tableBody.appendChild(row);
    });
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
document.querySelector("#button-filtre").addEventListener("click", () => {
    clearTable()
    filterCategorie = document.getElementById('Categorie').value || '';
    for (let index = 0; index < selectedItems.length; index++) {
        const element = selectedItems[index];
        document.getElementById('table-body').appendChild(element);
    }
    tabcreate();
});

// Pareil mais pour le form valider
document.querySelector("#form-confirmation").addEventListener("submit", function(event) {
    event.preventDefault();
    // Dans le form valider
    let outputValue = '';
    let first = true;
    selectedItems.forEach(rowSelected => {
        if(!first) {
            outputValue += ',';
        } else {
            first = false;
        }
        // C'est le code SAP
        outputValue += rowSelected.children[0].innerHTML;
    });

    document.querySelector("input[name='articles']").value = outputValue;
    this.submit();
});


function setEvent() {
    // evenement qui s'execute sur chaque ligne -> quand la checkbox change on ajoute une class
    let elements = document.querySelectorAll('tr');
    for (let index = 0; index < elements.length; index++) {
        const element = elements[index];
        let childrenList = element.children;
        for (let index = 0; index < childrenList.length; index++) {
            const child = childrenList[index];
            if (child.getAttribute("class") == 'checkbox') {
                child.addEventListener('change', () => {
                    if(selectedItems.indexOf(element) == -1){
                        selectedItems.push(element);
                    }else{
                        selectedItems.pop(element);
                    }
                })
            }
        }
    }
}

tabcreate();