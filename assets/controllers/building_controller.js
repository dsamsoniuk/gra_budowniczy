import { Controller } from '@hotwired/stimulus';

const BuildingInterface = {
    id: Number,
    name: String,
    goldCost: Number,
    ub_id: String,
    timeLeft: Number,
}

/**
 * Building
 */
export default class extends Controller {
    /** @type HTMLElement listConstructedBuildings  */
    static targets = ["template", "listAvailableBuildings", "listConstructedBuildings", "listUserBuildings"]

    timer = null
    avatarPath = ''
    availableBuildings = []
    buildingsInConstruction = []
    userBuildings = []

    connect() {
        this.reloadBuildingsList()
    }
    reloadBuildingsList(){
        clearInterval(this.timer)
        this.fetchBuildings()
            .then(() => {
                this.displayBuildings()
                this.runTimer()
            })
    }

    displayBuildings(){
        this.listAvailableBuildingsTarget.replaceChildren(...this.createBuildingList(this.availableBuildings, 'create'))
        this.listConstructedBuildingsTarget.replaceChildren(...this.createBuildingList(this.buildingsInConstruction, 'construct'))
        this.listUserBuildingsTarget.replaceChildren(...this.createBuildingList(this.userBuildings, 'builded'))
    }

    runTimer(){
        const self = this
        this.timer = setInterval(() => {

            var finishedBuilding = false

            if (self.buildingsInConstruction.length === 0) {
                clearInterval(this.timer)
            }

            self.buildingsInConstruction.forEach((element, index) => {
                if (element.timeLeft <= 0) {finishedBuilding = index}
            });

            if (finishedBuilding !== false) {
                // self.buildingsInConstruction.splice(finishedBuilding, 1)
                self.reloadBuildingsList()
                return
            }

            self.listConstructedBuildingsTarget.replaceChildren(...self.createBuildingList(self.buildingsInConstruction, 'construct'))
            // console.log('reload timer', self.buildingsInConstruction)
        }, 1000)
    }

    createBuildingList(list = [], mode = ''){
        return list.map((building) => {
            return this.createBuildingTemplate({mode: mode, building: building})
        })
    }
    async createBuilding(e){
        /** @type HTMLElement */
        const btn = e.target
        const id = btn.getAttribute('b-id')
        const response = await fetch(`/building/create/${id}`)
        // const building = await response.json()
        console.log('post building ->send')
        clearInterval(this.timer)
        this.dispatch('reloadStats')
        this.fetchBuildings()
            .then(() => {
                this.runTimer()
            })
        
        // this.reloadAfterTime(building.time)
        // this.dispatch("reloadConstructs", {detail: {par: 123}})
        // this.dispatch("reloadStats")
    }
    // /**
    //  * @typedef {Object} BuildingInterface
    //  * @property {string} name - Nazwa budynku
    //  */
    // /**@param {BuildingInterface} building */
    createBuildingTemplate({mode = '', building = null, actions = ''}){
        // CIEkAWOSTKA. tag template tylko posiada content -- to jest pod JS  zrobione
        const clone = this.templateTarget.content.cloneNode(true) 
        var timeLeft = ''

        if (mode == 'construct') {
            // timeLeft += `- czas: ${building.timeLeft}`
            building.timeLeft--;
            /** @type HTMLElement */
            const eleStats = clone.querySelector('.image-stats')
                eleStats.innerText = `czas: ${building.timeLeft}s`
        } else if (mode == 'create') {
            /** @type HTMLElement */
            const eleDeleteAction = clone.querySelector('.action-delete')
                eleDeleteAction.remove()
        } 
        
        if (mode == 'construct' || mode == 'builded') {
            /** @type HTMLElement */
            const eleBuildAction = clone.querySelector('.action-build')
                eleBuildAction.remove()
            /** @type HTMLElement */
            const eleDeleteAction = clone.querySelector('.action-delete')
                eleDeleteAction.setAttribute('ub-id', building.ub_id)
        } else {
            /** @type HTMLElement */
            const eleBuildAction = clone.querySelector('.action-build')
                eleBuildAction.setAttribute('b-id', building.id)
            /** @type HTMLElement */
            const eleStats = clone.querySelector('.image-stats')
                eleStats.innerText = `Koszt:  ${building.goldCost} sz. zł`
        }

        /** @type HTMLElement */
        const eleTitle = clone.querySelector('.image-title')
            eleTitle.innerText = `${building.name}`
        if (mode == 'construct') {
            /** @type HTMLElement */
            const ele = clone.querySelector('.image-av')
                ele.style.background = `url('/images/construct.png')`
        } else {
            /** @type HTMLElement */
            const ele = clone.querySelector('.image-av')
                ele.style.background = `url('${this.avatarPath}/${building.avatar}')`
        }

        return clone
    }

    async deleteBuilding(e){
        const id = e.target.getAttribute('ub-id')
        const response = await fetch(`/building/delete/${id}`)
        const data = await response.json()
        if (response.status === 200 && data.status === 'success') {
            this.reloadBuildingsList()
        }
    }

    async fetchBuildings(){
        const responsel = await fetch('/building/list')
        const data = await responsel.json()
        this.avatarPath = data['avatarPath']
        this.availableBuildings = data['data']

        const responsec = await fetch('/building/user-constructions')
        this.buildingsInConstruction = await responsec.json()

        const responseb = await fetch('/building/user-buildings')
        this.userBuildings = await responseb.json()

        // return typeof this.userBuildings == Array && responsec.status == 200 && responseb.status == 200
    }

}
