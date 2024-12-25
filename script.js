const form =document.getElementById('form')
const firstname_input =document.getElementById('firstname-input')
const email_input =document.getElementById('email-input')
const password_input=document.getElementById('password-input')
const repeat_password_input=document.getElementById('repeat-password-input')

form.addEventListener('submit',(e)=>{
//e.preventDefault()//
/*let errors=[]

if(firstname_input){

    //if we have a first name than we are in signup page
    errors= getsignupformErrors(firstname_input.value , email_input.value,password_input.value, repeat_password_input.value)
}
else{
    //if we dont have first name its mean we are in login page

errors=getloginformErrors(email_input.value,password_input.value)


}
if (errors.length > 0){
    //if there is any error in the error
    e.preventDefault()
}*/
})

/*function getsignupformErrors(firstname,email,password){
    let errors =[]
if(firstname=='' || firstname==null){
    errors.push('first-name is required')
    firstname_input.parentElement.classList.add('incorrect')
}
if(email=='' || email==null){
    errors.push('email is required')
    email_input.parentElement.classList.add('incorrect')
}
if(password=='' || password==null){
    errors.push('password is required')
    password_input.parentElement.classList.add('incorrect')
}
return errors;
}*/