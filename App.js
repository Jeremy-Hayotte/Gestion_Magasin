let filterCategorie = '';
var lesTrucsCheck = [];

const linkElement = document.createElement("link");
linkElement.rel = "stylesheet";
linkElement.href = "styles.css";
document.head.appendChild(linkElement);

const selecctarticle = document.getElementsByClassName("input-selection");
const selectedItemsBefore = document.querySelector("input[name='selectedItems']").value;


function tabcreate() {
    let url = "http://localhost/getdata.php";
    if (filterCategorie != '') {
        url = url + "?categorie="+filterCategorie;
    }
    fetch(url).then(response => response.json()).then(data => {
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
            checkbox.classList.add("checkbox");
        
            CODESAP.classList.add('center');
            CODEPOLE.classList.add('center');
            DESCRIPTION.classList.add('center');
            UNITE_DE_MESURE.classList.add('center');
            CATEGORIE.classList.add('center');
            selection.classList.add('center', 'selection');
        
            CODESAP.innerText = article.CODESAP;
            CODEPOLE.innerText = article.CODEPOLE;
            DESCRIPTION.innerText = article.Description;
            UNITE_DE_MESURE.innerText = article.Unitédemesure;
            CATEGORIE.innerText = article.Categorie;
        
            row.classList.add('getrow');
            row.appendChild(CODESAP);
            row.appendChild(CODEPOLE);
            row.appendChild(DESCRIPTION);
            row.appendChild(UNITE_DE_MESURE);
            selection.appendChild(checkbox);
            row.appendChild(selection);
        
            tableBody.appendChild(row);
        });

        for (let index = 0; index < lesTrucsCheck.length; index++) {
            const element = lesTrucsCheck[index];
            tableBody.appendChild(element);
        }
        setEvent();
    }).catch(error => {
        // Gérer les erreurs de récupération
        console.error('Une erreur s\'est produite:', error);
    });
}

function clearTable() {
    document.getElementById('table-body').innerHTML = '';
}

function setEvent() {
    // evenement qui s'execute sur chaque ligne -> quand la checkbox change on ajoute une class
    let lesLignesDeLaTable = document.getElementsByClassName('getrow');
    for (let index = 0; index < lesLignesDeLaTable.length; index++) {
        const uneLigne = lesLignesDeLaTable[index];
        let childrenList = uneLigne.children;
        for (let index = 0; index < childrenList.length; index++) {
            const child = childrenList[index];
            if (child.getAttribute("class") == 'center selection') {
                let checkboxInCell = child.children[0];
                checkboxInCell.addEventListener('change', () => {
                    if(lesTrucsCheck.indexOf(uneLigne) == -1){
                        lesTrucsCheck.push(uneLigne);
                    }else{
                        lesTrucsCheck.pop(uneLigne);
                    }
                })
            }
        }
    }
}


// Executer quand le form filtre est envoyé
document.querySelector("#submit-filter").addEventListener("click", () => {
    clearTable()
    filterCategorie = document.getElementById('Categorie').value || '';
    console.log(filterCategorie)
    for (let index = 0; index < lesTrucsCheck.length; index++) {
        const element = lesTrucsCheck[index];
        document.getElementById('table-body').appendChild(element);
    }
    tabcreate();
});

// Pareil mais pour le form valider
document.querySelector("#form-confirmation").addEventListener("submit", function(event) {
    event.preventDefault();
    // Dans le form valider
    let isFirst = true;
    let inputValue = '';
    for (let index = 0; index < lesTrucsCheck.length; index++) {
        const element = lesTrucsCheck[index];
        if (!isFirst) {
            inputValue += ",";
        }
        isFirst = false
        inputValue += element.children[0].innerHTML;   
    }
    document.querySelector("input[name='articles']").value = inputValue;
    this.submit();
});


tabcreate();
