window.onload = () => {
    const deviceType = document.querySelector('#deviceType') ;
    const deviceModel = document.querySelector('#deviceModel') ;
    const sparePart = document.querySelector('#sparePart') ;
    
    deviceType.addEventListener("change", (event) => {
        const value = event.target.value ;
        const Params = new URLSearchParams() ;
        const Url = new URL(window.location.href) ;
        
        Params.append('type', value) ;

        fetch('/deviceType/' + value)
        .then (response => {
            deviceModel.disabled = false ;
            console.log(response)
        })
        .catch(error => alert(error)) ;

    }) ;

    deviceModel.addEventListener("change", (event) => {
        
    }) ;

    sparePart.addEventListener("change", (event) => {
        
    }) ;
}