import { Controller } from '@hotwired/stimulus';

/**
 * Profile
 */
export default class extends Controller {
    connect() {
        this.sources = { gold: 0 }
        this.reloadStats()
    }
    async reloadStats() {
        const response = await fetch('/profile/stats');
        const body = await response.json()

        this.sources = { gold: body.source_gold }

        const content = Object.entries(this.sources).map(([key,value]) => {
            return `${key}:${value}`
        })

        this.element.innerHTML = `Zasoby: ${content}`
    }
}
