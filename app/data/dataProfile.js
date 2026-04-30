let HOST_URL = "https://mmi.unilim.fr/~mamedov1/SAE2.03-MAMEDOV/server";

let DataProfile = {};

DataProfile.add = async function(formData) {
    let response = await fetch(HOST_URL + "/script.php?todo=addProfile", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData)
    });
    return await response.json();
};

export { DataProfile };