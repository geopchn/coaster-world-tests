import "../../../css/pages/park/view.scss";
import { WeatherWidget } from "../../components/weather-widget";

const widgetElement = document.querySelector('.weather-widget');
new WeatherWidget(widgetElement);
