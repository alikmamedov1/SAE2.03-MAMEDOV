let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};

NavBar.format = function (profiles = [], activeProfile = null) {
  let html = template;

  // 1. Формируем список опций в селекторе
  let optionsHtml = profiles.map(p => {
    let selected = (activeProfile && p.id == activeProfile.id) ? "selected" : "";
    return `<option value="${p.id}" ${selected}>${p.name} (${p.age_restriction}+)</option>`;
  }).join("");

  // 2. Формируем аватар активного профиля
  let avatarHtml = "";
  if (activeProfile && activeProfile.avatar) {
    let avatarPath = "/~mamedov1/SAE2.03-MAMEDOV/server/images/profiles/" + activeProfile.avatar;
    avatarHtml = `<img src="${avatarPath}" class="navbar__avatar" alt="Avatar">`;
  } else {
    avatarHtml = `<span class="navbar__avatar--empty"></span>`;
  }

  // 3. ЛОГИКА ДЛЯ ВКЛАДКИ FAVORIS:
  // Если профиль выбран, вставляем пункт меню, иначе оставляем пустоту
  let favTabHtml = "";
  if (activeProfile) {
    favTabHtml = `<li class="navbar__item" onclick="C.handlerShowFavorites()">Favoris</li>`;
  }

  // 4. Выполняем все замены в шаблоне
  html = html.replace("{{options}}", optionsHtml);
  html = html.replace("{{activeAvatar}}", avatarHtml);
  html = html.replace("{{favTab}}", favTabHtml); // Замена нашей новой метки
  html = html.replace("{{hAbout}}", "C.handlerAbout()"); 

  return html;
};

export { NavBar };