import { Controller } from '@hotwired/stimulus';

/*
 * Hello
 */
export default class extends Controller {
    static targets = ["ufo"]
    static values = {
        ilosc: Number, 
        products: Object, 
        wartosc: {type: Number, default: 3}
    }
    connect() {
        console.log(this.productsValue)
        console.log('ufo', this.ufoTarget)
        console.log('ilosc', this.iloscValue)
        this.petla()
    }
    msg(){
        console.log('hello dispatch')
        this.dispatch('greethi')
    }
    petla(){
        const self = this
        this.loop = setInterval(() => {
            console.log('loop:' + self.wartoscValue)
            if (self.wartoscValue < 6) self.wartoscValue++
            else clearInterval(this.loop)
        }, 1000)
    }
}

// <div>
//     <div data-controller="hello" data-hello-ilosc-value="5" data-hello-products-value='{"products": [3,45,5]}'>
//         <div>
//             <button data-action="click->hello#msg">wyslij</button>
//             <div data-hello-target="ufo">objekt</div>
//         </div>
//     </div>
//     <div data-controller="hi" data-action="hello:greethi@window->hi#greet">
//     </div>
// </div>

// Przyklad submit blokady czyli jak klikne submit wykonaj funkcje form#send  i stimulus oferuje blokate :prevent
// <form data-controller="form" data-action="submit->form#send:prevent">
//   <input type="text" placeholder="Wpisz coś..." required>
//   <button type="submit">Wyślij</button>
// </form>

// METODA send()
//   send(event) {
//     // Nie musisz pisać event.preventDefault()! Stimulus zrobił to za Ciebie (:prevent).
//     console.log("Formularz został przechwycony. Strona się nie przeładuje.")
//   }