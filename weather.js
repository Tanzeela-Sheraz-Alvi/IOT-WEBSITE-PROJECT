// Function to get weather data from OpenWeatherMap API and update the page 
function getWeatherData() {
    const apiKey = '058b3771d691aeab6d028d0c030e5eff';
    const city = 'gujranwala';  
    const units = 'metric'; 
    
    // Make AJAX request to fetch weather data
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `weather_api.php?city=${city}&units=${units}&apikey=${apiKey}`, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const data = JSON.parse(xhr.responseText);
            if (data.success) {
                document.getElementById('temperature').textContent = `${data.temp}°C`;
                document.getElementById('humidity').textContent = `${data.humidity}%`;
                saveWeatherData(data.temp, data.humidity);
                updateWeatherIcon(data.weather);
            } else {
               // alert('Error fetching weather data.');
            }
        }
    };
    xhr.send();
}

// Function to send temperature and humidity to the backend to save in the database
function saveWeatherData(temp, humidity) {
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'save_weather_data.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            console.log('Weather data saved successfully!');
        }
    };
    xhr.send(`temp=${temp}&humidity=${humidity}`);
}

// Function to update the weather icon based on weather conditions
function updateWeatherIcon(weather) {
    const weatherBox = document.querySelector('.temp'); 
    
    if (weather.includes('clear') || weather.includes('sunny')) {
        // If weather is sunny
        weatherBox.innerHTML = `<img src="images/sunny.png" alt="Sunny"> Sunny <span class="cloudy">Humidity</span>`;
    } else if (weather.includes('cloud') || weather.includes('overcast')) {
        // If weather is cloudy
        weatherBox.innerHTML = `<img src="images/cloudy.png" alt="Cloudy"> Cloudy <span class="cloudy">Humidity</span>`;
    } else if (weather.includes('rain') || weather.includes('drizzle')) {
        // If weather is rainy
        weatherBox.innerHTML = `<img src="images/rainy.png" alt="Rainy"> Rainy <span class="cloudy">Humidity</span>`;
    } else if (weather.includes('snow')) {
        // If weather is snowy
        weatherBox.innerHTML = `<img src="images/snowy.png" alt="Snowy"> Snowy <span class="cloudy">Humidity</span>`;
    } else if (weather.includes('sunset') || weather.includes('dusk')) {
        // If weather is sunset
        weatherBox.innerHTML = `<img src="images/sunset.png" alt="Sunset"> Sunset <span class="cloudy">Humidity</span>`;
    } else {
        // Default weather icon (if none of the above conditions match)
        weatherBox.innerHTML = `<img src="images/default.png" alt="Weather"> Weather <span class="cloudy">Humidity</span>`;
    }
}

// Call getWeatherData function every 10 minutes (600,000 ms)
setInterval(getWeatherData, 600000);

// Initially call it when the page loads
window.onload = getWeatherData;
