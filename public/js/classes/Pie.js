import Slice from "./Slice.js";
export default class Pie {
    constructor(containerName) {
        this.slices = new Array();
        this.circumference = 0;
        this.total = 0;
        this.containerName = containerName;
    }
    SetCircumference(radius) {
        this.circumference = 2 * Math.PI * radius;
        this.id = Pie.count++;
    }
    AddSlice(value, label = "fff") {
        this.total += value;
        let newSlice = new Slice(value, this, label);
        this.updateChildren();
    }
    updateChildren() {
        this.slices = this.slices.sort((a, b) => a.value + b.value);
        this.slices.forEach((slice, sliceIdx) => {
            slice.parentPie = this;
            if (sliceIdx != 0) {
                slice.start = this.slices[sliceIdx - 1].end;
            }
            else {
                slice.start = 0;
            }
            slice.update(this.total);
        });
        this.draw(this.containerName);
    }
    draw(containerName) {
        this.containerName = containerName;
        const container = document.getElementById(containerName);
        container.innerHTML = ``;
        let newBase = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        let overlay = document.createElement('div');
        let tooltip = document.createElement('p');
        tooltip.classList.add('--svgchart-tooltip');
        newBase.appendChild(tooltip);
        container.appendChild(overlay);
        container.style.width = "200px";
        container.style.height = "200px";
        container.style.position = "relative";
        newBase.setAttribute("viewBox", "0 0 100 100");
        newBase.classList.add("--svgchart-circle");
        newBase.style.position = "relative";
        newBase.style.width = "200px";
        newBase.style.height = "200px";
        newBase.onmouseenter = () => {
            let tooltip = document.querySelector('.--svgchart-tooltip');
            tooltip.style.opacity = "1";
        };
        newBase.onmouseleave = () => {
            let tooltip = document.querySelector('.--svgchart-tooltip');
            tooltip.style.opacity = "0";
        };
        this.SetCircumference(25);
        container.appendChild(newBase);
        this.slices.forEach((slice, sliceIdx) => {
            newBase.appendChild(slice.draw());
        });
        //return newBase;
    }
}
Pie.count = 0;
