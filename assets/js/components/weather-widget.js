import { DateTime } from 'luxon';

export class WeatherWidget{
    constructor(widgetElement) {
        this.widgetElement = widgetElement;
        this.loadData();
    }

    async loadData(){
        const url = this.widgetElement.dataset.url;
        const response = await fetch(url);
        const data = await response.json();
        this.display(data.forecasts);
    }

    display(forecasts){
        for(const forecast of forecasts){
            const date = DateTime.fromSQL(forecast.date.date);

            const forecastELement = document.createElement('div');
            forecastELement.innerText = date.toFormat('dd/MM/yyyy') + ' - ';
            forecastELement.innerText += forecast.label + ' (' + forecast.temperature + '°C)';

            this.widgetElement.appendChild(forecastELement);
        }
    }
}
