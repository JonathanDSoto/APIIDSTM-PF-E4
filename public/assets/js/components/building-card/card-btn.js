import { base } from "../../../css/base.js";
import {icons} from '../../../img/icons/uabcsIcons.js'
import { LitElement, css, html } from "../../../vendor/js/lit.js";

class CardButton extends LitElement {
    constructor() {
        super();
        this.bgColor = "red";
        this.onClick = () => console.log("No action");
    }
    static properties = {
        onclick: { type: Function },
        bgColor: { type: String },
        icon: {type:String}
    };

    static styles = [
        base,
        css`
            .btn-delete {
                display: flex;
                justify-content: center;
                align-items: center;
                border-radius: 50%;
                width: 1.7em;
                height: 1.7em;
                background-color: rgba(255, 255, 255, 0.35);
                z-index: 3;
                border: none;
                color: white;
                outline: none;
                font-weight: bold;
                font-family: inherit;
                font-size: 1.1em;
                overflow: hidden;
                cursor: pointer;
                transition: all ease 0.25s;
            }
            
            .btn-delete:hover {
                background-color: var(--bg-color);
                /* background-color: rgb(115 103 240); */
            }
            svg {
                fill: white;
            }
        `,
    ];

    render() {
        return html`
            <button
                style="--bg-color: ${this.bgColor}"
                @click=${(context) => this.onClick(context)}
                class="btn-delete delete"
                id="modify"
            >
                ${icons[this.icon]}
            </button>
        `;
    }
}
customElements.define("uabcs-card-btn", CardButton);
