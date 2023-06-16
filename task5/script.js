let btnAdd = document.querySelector('button');
let table = document.querySelector('tbody');
let nameInput = document.querySelector('#name');

function initTableHeaders(){
    let idHeader = document.querySelector('#idHeader');
    idHeader.addEventListener('click', () =>{
        sortTable(Headers.ID);
    });
    let nameHeader = document.querySelector('#nameHeader');
    nameHeader.addEventListener('click', () =>{
        sortTable(Headers.NAME);
    });
    let scoreHeader = document.querySelector('#scoreHeader');
    scoreHeader.addEventListener('click', () =>{
        sortTable(Headers.SCORE);
    });
}

const Headers = { ID: 'id', NAME: 'name', SCORE: 'score' };
function sortTable(headerToSort) {
    switch(headerToSort)
    {
        case Headers.ID:
            let sortedRowsById = Array.from(table.rows).slice(1).sort((rowA, rowB) => {
                return rowA.cells[0].innerHTML - rowB.cells[0].innerHTML;
            });
            table.append(...sortedRowsById);
            break;
    
        case Headers.NAME:
            let rows, switching, i, x, y, shouldSwitch;
            switching = true;
            while (switching) {
                switching = false;
                rows = table.rows;
                for (i = 1; i < (rows.length - 1); i++) {
                    shouldSwitch = false;
                    x = rows[i].getElementsByTagName("TD")[1];
                    y = rows[i + 1].getElementsByTagName("TD")[1];
                    if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
                        shouldSwitch = true;
                        break;
                    }
                }
                if (shouldSwitch) {
                rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
                switching = true;
                }
            }
            break;
    
        case Headers.SCORE:
            let sortedRowsByScore = Array.from(table.rows).slice(1).sort((rowA, rowB) => {
                return rowA.cells[2].innerHTML - rowB.cells[2].innerHTML;
            });
            table.append(...sortedRowsByScore);
            break;
       
        default:
            console.log('???');
    }
}

function insertNewRow(startValue, endValue, targetId, name){
    $.ajax({
        url: 'randomScore.php',
        type: 'GET',
        cache: false,
        data: { 'startValue': startValue, 'endValue': endValue},
        dataType: 'html',
        beforeSend: function() {
            btnAdd.disabled = true;
        },
        success: function(data) {
            let template = `
                            <tr>
                                <td>${targetId}</td>
                                <td>${name}</td>
                                <td>${data}</td>
                            </tr>`;
            table.innerHTML += template;
            btnAdd.disabled = false;
            table.style.visibility = "visible";
            initTableHeaders();
        }
    });
}

initTableHeaders();
btnAdd.addEventListener('click', () => {
    let rws = table.rows;  
    let id = rws.length;

    let namesInput = nameInput.value;
    nameInput.value = "";
    if(namesInput == ""){
        alert("Введите хотя бы что-нибудь ;-)");
        return
    }
    if (!namesInput.match('^[,а-яА-ЯёЁ\s]+$')) {
        alert("Допускаются только символы кириллицы и запятая!");
        return
    }
    let names = namesInput.split(",");
    if(names.length <= 0) {
        alert("Для добавления участников введите хотя бы одно имя!");
        return
    }
    let addedCount = 0;
    for (var i = 0; i < names.length; i++) {
        let name = names[i]
        if(name) {
            let targetId = id + addedCount;
            insertNewRow(0, 100, targetId, name);
            addedCount++;
        }
    }
    if(addedCount == 0) {
        alert("Для добавления участников введите хотя бы одно имя!");
        return
    }
});

nameInput.addEventListener("keyup", function(event) {
  if (event.keyCode === 13) {
    event.preventDefault();
    btnAdd.click();
  }
});
