document.addEventListener("DOMContentLoaded", () => {
    const lookupButton = document.getElementById('lookup');
    const countryData = document.getElementById('country');
    const resultDiv = document.getElementById('result');

    lookupButton.addEventListener('click', () => {
        let country = countryData.value.trim();

        if(!country){
            fetch('world.php')
                .then(response => response.text())
                .then(data => {
                    resultDiv.innerHTML = data;
                })
                .catch(error => {
                    console.error('An error has occurred:', error);
                    resultDiv.innerHTML = 'No Results Generated.';
                });
        }else{
            fetch(`world.php?country=${encodeURIComponent(country)}`)
                .then(response => response.text())
                .then(data => {
                    resultDiv.innerHTML = data;
                })
                .catch(error => {
                    console.error('An error has occured:', error);
                    resultDiv.innerHTML = 'No Results Generated.';
                });
            }
    });
});