// registration
let close = document.getElementById("closePopup");

let fname = document.getElementById("fname");
let surname = document.getElementById("surname");
let email = document.getElementById("email");
let login = document.getElementById("login");
let birthday = document.getElementById("birthday");
let password = document.getElementById("password");

fname.addEventListener("change", e => {

    if (fname.value.search("^[А-Я][а-я]{1,20}$|^[A-Z][a-z]{1,20}$")) {
        fnameErr.textContent = "Некорректное имя"
    } else {
        fnameErr.textContent = "";
    }
});

surname.addEventListener("change", e => {

    if (surname.value.value.search("^[А-Я][а-я]{1,20}$|^[A-Z][a-z]{1,20}$")) {
        snameErr.textContent = "Некорректная фамилия"
    } else {
        snameErr.textContent = "";
    }
});

email.addEventListener("change", e => {

    if (email.value.search("^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$")) {
        emailErr.textContent = "Некорректный email";
    } else {
        emailErr.textContent = "";
    }
});

login.addEventListener("change", e => {

    if (login.value.search("^[А-Я][а-я]{1,20}$|^[A-Z][a-z]{1,20}$")) {
        loginErr.textContent = "Некорректный логин";
    } else {
        loginErr.textContent = "";
    }
});

birthday.addEventListener("change", e => {
    console.log(birthday.value);
    if (birthday.value == "") {
        birthErr.textContent = "Введите дату рождения"
    } else {
        birthErr.textContent = "";
    }
});

password.addEventListener("change", e => {
    if (password.value == "") {
        passErr.textContent = "Введите пароль";
    } else {
        passErr.textContent = "";
    }
});

function cangritulateUser() {
    document.querySelector(".signUp").innerHTML = "<h4 style='color : green'>Вы успешно зарегистрировались</h4>"
}