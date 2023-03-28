const btnCall = document.querySelector('.btnCall')
const answer = document.querySelector('.answer')
let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')

// let dateFrom = '2023-03-05'
// let dateTo = '2023-03-11'

btnCall.addEventListener('click',async function (){
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    let url = document.querySelector("#url").value
    let dateFrom = document.querySelector("#date").value
    let api = document.querySelector("#api").value

    const response = await fetch(url + `?dateFrom=${dateFrom}`, {
        method: 'GET', // *GET, POST, PUT, DELETE, etc.
        headers: {
          'Authorization': api,  
          'Content-Type': 'application/json'
        },
      })

      json = await response.json()
      console.log(dateFrom)

      if (json) {

        const data = await fetch('/api',
            {
                method: 'POST',
                credentials: "same-origin",
                headers: {
                    'Content-Type': 'application/json',
                    "Accept": "application/json, text-plain, */*",
                    "X-Requested-With": "XMLHttpRequest",
                    "X-CSRF-TOKEN": token,
                },
                body: JSON.stringify(json)
        })

        let result = await data.json()
        
        
      }
})