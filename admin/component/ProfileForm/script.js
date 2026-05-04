export const ProfileForm = {
    format: function () {
        return `
            <form id="profileForm">
                
                <input type="hidden" id="p_id" value="0">
                
                <input type="text" id="p_name" placeholder="Nom du profil" required>
                <input type="text" id="p_avatar" placeholder="Nom de l'avatar (ex: avatar1.png)">
                
                <label>Restrictions d'âge :</label>
                <select id="p_age">
                    <option value="0">0 (Tous publics)</option>
                    <option value="12">12+</option>
                    <option value="16">16+</option>
                    <option value="18">18+</option>
                </select>
                
                <button type="submit">Enregistrer le profil</button>
            </form>
            <div id="profile-list-container"></div>
        `;
    }
};