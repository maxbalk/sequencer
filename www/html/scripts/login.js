function processForm(route){
    let displayArea = document.getElementById("displayArea");
    let form = document.getElementById('loginForm');
    form.elements[0].value = route;
    for(let el of form.elements){
        if(el.value==""){
            displayArea.innerHTML = "Sorry, but all fields are required";
            return;
        }
        el.value = encodeURIComponent(el.value);
    }
    form.action = "?route="+route;
    form.submit();
}