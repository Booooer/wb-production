const switchTable = document.querySelector('.switch-table-name')
let tableName = document.getElementById('table-name')
const formApi = document.getElementById('form-api')

switchTable.addEventListener('click',function (){
    formApi.action = `update/${switchTable.value}`
})