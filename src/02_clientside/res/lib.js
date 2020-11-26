document.body.innerHTML = `
<h1 class="header">Welcome to the LoveCalculator</h1>
<div id="card" style="display: flex; flex-direction: column; padding: 10px; padding-left: 20px" class="card">
    <h1>Namensliste</h1>    
    <div id="content" style="align-self: center; padding: 20px;">
        <table class="tables">
            <thead>
                <tr>
                    <th class="table-head">Dein Name</th>
                    <th class="table-head">Dein Schwarm</th>
                    <th class="table-head">Euer Match</th>
                </tr>
            </thead>
            <tbody id="tablebody">
            </tbody>
        </table>
    </div>
</div>`;