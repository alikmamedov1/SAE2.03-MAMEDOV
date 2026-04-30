let templateFile = await fetch("./component/NavBar/template.html");
let template = await templateFile.text();

let NavBar = {};

NavBar.format = function (profiles = [], activeProfile = null) {
  let html = template;
  

  let optionsHtml = profiles.map(p => {
    let selected = (activeProfile && p.id == activeProfile.id) ? "selected" : "";
    return `<option value="${p.id}" ${selected}>${p.name} (${p.age_restriction}+)</option>`;
  }).join("");


  let avatarHtml = "";
  if (activeProfile && activeProfile.avatar) {

    let avatarPath = "/~mamedov1/SAE2.03-MAMEDOV/server/images/profiles/" + activeProfile.avatar;
    avatarHtml = `<img src="${avatarPath}" class="navbar__avatar" alt="Avatar">`;
  } else {

    avatarHtml = `<span class="navbar__avatar--empty"></span>`;
  }

  html = html.replace("{{options}}", optionsHtml);
  html = html.replace("{{activeAvatar}}", avatarHtml);
  html = html.replace("{{hAbout}}", "console.log('About clicked')"); 
  
  return html;
};

export { NavBar };
