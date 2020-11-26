document.body.innerHTML = `
<h1 class="header">Welcome to the LoveCalculator</h1>
<div id="card" style="display: flex; flex-direction: column; padding: 10px; padding-left: 20px" class="card">
    <h1>Namensliste</h1>    
    <div id="content" style="align-self: center; padding: 20px;">
        <table class="tables">
            <thead>
                <tr>
                    <th onclick="renderTableBody('n1')" class="table-head">Dein Name</th>
                    <th onclick="renderTableBody('n2')" class="table-head">Dein Schwarm</th>
                    <th onclick="renderTableBody('points')" class="table-head">Euer Match</th>
                </tr>
            </thead>
            <tbody id="tablebody">

            </tbody>
        </table>
    </div>
</div>`;

let matches = null;


const xhr = new XMLHttpRequest();
xhr.onreadystatechange = function () {
    if (this.readyState === 4 && this.status === 200) {
        matches = JSON.parse(xhr.responseText);
        matches.forEach(calculatePoints);
        renderTableBody();
    }
};

function sortMatchesByN1() {
    matches.sort((matchA, matchB) => {
        const firstNameA = matchA.n1.toLowerCase();
        const firstNameB = matchB.n1.toLowerCase();
        if (firstNameA < firstNameB) {
            return -1;
        } else if (firstNameA > firstNameB) {
            return 1;
        } else {
            return 0;
        }
    });
}


function renderTableBody(column = 'n1') {

    switch (column) {
        case 'n1':
            sortMatchesByN1();
            break;
        case 'n2':
            matches.sort((matchA, matchB) => {
                const firstNameA = matchA.n2.toLowerCase();
                const firstNameB = matchB.n2.toLowerCase();
                if (firstNameA < firstNameB) {
                    return -1;
                } else if (firstNameA > firstNameB) {
                    return 1;
                } else {
                    return 0;
                }
            });
            break;
        case 'points':
            matches.sort((matchA, matchB) => {
                const pointsA = matchA.points;
                const pointsB = matchB.points;
                if (pointsA > pointsB) {
                    return -1;
                } else if (pointsA < pointsB) {
                    return 1;
                } else {
                    return 0;
                }
            });
            break;
        default:
            sortMatchesByN1();
            break;
    }

    let tableBody = '';
    matches.forEach((match) => {
        tableBody += `
        <tr>
            <td style="text-align: center;" >${match.n1}</td>
            <td style="text-align: center;" >${match.n2}</td>
            <td style="text-align: center;" >${match.points}</td>
        </tr>
        `;
    });
    const tBody = document.getElementById('tablebody');
    tBody.innerHTML = tableBody;

}


function calculatePoints(match) {
    let value = 0;
    for (let index = 0; index < match.n1.length; index++) {
        value += match.n1.charCodeAt(index)
    }
    for (let index = 0; index < match.n2.length; index++) {
        value += match.n2.charCodeAt(index)
    }
    match.points = ((value % 100) + 1);
}

xhr.open('POST', '/02_clientside/api/read.php', true);
xhr.send(null)