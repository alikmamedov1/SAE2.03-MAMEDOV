// Загружаем файл шаблона
let templateFile = await fetch("./component/ProfileForm/template.html");
let template = await templateFile.text();

let ProfileForm = {};

// Метод для возврата HTML-кода формы
ProfileForm.format = function () {
    return template;
};

export { ProfileForm };