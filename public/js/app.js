const switchTable = document.querySelector('.switch-table-name')
let tableName = document.getElementById('table-name')
tableName.innerHTML = switchTable.value

switchTable.addEventListener('click',function (){
    tableName.innerHTML = switchTable.value
})