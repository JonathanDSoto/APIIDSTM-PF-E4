import { base } from "../../../css/base.js";
import { LitElement, css, html } from "../../../vendor/js/lit.js";

class BuildingCard extends LitElement {
    constructor() {
        super();

        this.data = {
            id: 0,
            name: "",
            codeName: "",
            latitude: 0,
            longitude: 0,
            radius: 0,
            imageUrl: ""
        }
    }

    static properties = {
        data: {type: Object}
        // data-id="" 
        // data-name="" 
        // data-codeName="" 
        // data-latitude="" 
        // data-altitude=""
        // data-radius=""
        // imageUrl="" 
    };

    static styles = [
        base,
        css`
            :host {
                --horizontal_cards: 3;
                width: calc((100% / var(--horizontal_cards)) - 10px);
                height: 400px;
            }
            .wrapper {
                position: relative;
                display: flex;
                width: 100%;
                height: 100%;
                overflow: hidden;
                justify-content: center;
                align-items: center;
                border-radius: 10px;
            }
            .wrapper::before {
                position: absolute;
                content: "";
                width: 100%;
                height: 100%;
                /* background: red; */
                background-color: rgba(0, 0, 0, 0.25);
                border-radius: 10px;

                /* filter: blur(40px); */
                z-index: 1;
                /* border: 1px solid white; */
                display: flex;
                justify-content: center;
                align-items: center;
                transition: all ease 0.4s;
            }

            .wrapper:not(:hover)::before {
                background-color: rgba(0, 0, 0, 0);
            }

            .container {
                width: 100%;
                height: 100%;
                display: flex;

                position: relative;
                background-color: #2f3349;
                border-radius: 10px;
                overflow: hidden;
                filter: blur(3px);
                transition: all ease 0.4s;
            }

            .wrapper:not(:hover) .container {
                filter: blur(0px);
            }

            .container::before {
                content: "";
                position: absolute;
                width: 100%;
                height: 100%;
                background: linear-gradient(
                    rgba(0, 0, 0, 0.65),
                    transparent,
                    rgba(0, 0, 0, 0.65)
                );
            }
            img {
                /* position: relative; */
                width: 100%;
                height: 100%;
                object-fit: cover;
                object-position: center;
            }
            .info_container {
                position: absolute;
                bottom: 10px;
                left: 10px;
            }

            .title_card {
                font-size: 1.8em;
                color: white;
                font-weight: bold;
            }

            .subtitle_card {
                color: white;
            }

            .btn-container {
                opacity: 0;
                transition: all ease 0.25s;
            }

            .wrapper:hover .btn-container {
                opacity: 1;
            }
        `,
    ];

    render() {
        let {name, codeName, imageUrl} = this.data;
        
        return html`
            <div class="wrapper">
                <div
                    class="btn-container"
                    style="position:absolute; z-index: 1; display: flex; gap: 40px; font-size: 2em;"
                >
                    <slot name="delete-btn"></slot>
                    <slot name="modify-btn"></slot>
                    <!-- <button @click=${() =>
                        this.modify_callback(
                            this
                        )} class="btn-delete modify" id="delete">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            height=".8em"
                            viewBox="0 0 512 512"
                        >
                            <path
                                d="M362.7 19.3L314.3 67.7 444.3 197.7l48.4-48.4c25-25 25-65.5 0-90.5L453.3 19.3c-25-25-65.5-25-90.5 0zm-71 71L58.6 323.5c-10.4 10.4-18 23.3-22.2 37.4L1 481.2C-1.5 489.7 .8 498.8 7 505s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L421.7 220.3 291.7 90.3z"
                            />
                        </svg>
                    </button>

                    <button @click=${() =>
                        this.delete_callback(
                            this
                        )} class="btn-delete delete" id="modify">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            height=".8em"
                            viewBox="0 0 448 512"
                        >
                            <path
                                d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"
                            />
                        </svg>
                    </button> -->
                </div>

                <a href="#" class="container">
                    <img src=${imageUrl} />
                    <div class="info_container">
                        <p class="title_card">${codeName}</p>
                        <p class="subtitle_card">${name}</p>
                    </div>
                </a>
            </div>
        `;
    }
}
customElements.define("building-card", BuildingCard);
