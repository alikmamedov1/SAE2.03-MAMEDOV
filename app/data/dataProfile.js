let HOST_URL = "../server";
let DataProfile = {};

DataProfile.add = async function(formData) {
    let response = await fetch(HOST_URL + "/script.php?todo=addProfile", {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(formData) 
    });
    return await response.json();
};

DataProfile.read = async function() {
    let response = await fetch(HOST_URL + "/script.php?todo=readProfiles");
    return await response.json();
};

export { DataProfile };