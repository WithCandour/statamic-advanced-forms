export default class PostcoderAddress {
    constructor(config) {
        this.config = config
        this.init()
    }

    init = () => {
    
        this.endpoint = 'https://ws.postcoder.com/pcw/' + this.config.apikey + '/address/'
        this.addresses = {}
    
        this.searchbutton = document.querySelector(this.config.searchbutton)
        this.searchterminput = document.querySelector(this.config.searchterm)
    
        //hide the no result message
        this.noresultmessage = document.querySelector(this.config.noresultmessage)
        this.noresultmessage.style.display = 'none'
    
        // create an empty select and place it hidden in the page
        this.select = document.createElement('select')
        this.select.style.display = 'none'
        document.querySelector(this.config.addressselectioncontainer).appendChild(this.select)
    
        // create and append the top 'select an address' option.
        let option = document.createElement('option')
        option.text = 'Select an address'
        this.select.appendChild(option)
    
        // add select change event listener to the dropdown
        this.select.addEventListener('change', this.handleSelectChange )
    
        // add click event listener to the search button, to call the search function
        this.searchbutton.addEventListener('click', this.search)
    
        // add 'enter' event listener to the search input, to call the search function
        this.searchterminput.addEventListener('keyup', event =>{
        if (event.keyCode === 13) {
            event.preventDefault()
            this.search()
        }
        })
    
        // determine the number of addresslines required
        this.addresslines = 0
        for (let i = 1; i <= 4; i++) {
            if( this.config['addressline'+i] !== ''){
                this.addresslines ++
            }
        }    
    
    }
    
    handleSelectChange = event => {
    
        // check to see if this selection was to load the next page of results
        if( this.select.value.charAt(0) === 'p'){
        
            // search the next page of results
            let page = this.select.value.substring(1)
            this.search(event, page)
    
        }else{   
    
            this.selectAddress( this.select.value )
    
        }     
    }
    
    search = (event, page = 0) => {
    
        let searchterm = encodeURIComponent(this.searchterminput.value)
    
        //hide the no result message
        this.noresultmessage.style.display = 'none'
    
        // hide the select
        this.select.style.display = 'none'
    
        //determine the country
        if(typeof this.config.countrycode !== 'undefined' && this.config.countrycode !== ''){
        // defined in config
        var country = this.config.countrycode
        }else{
        // get from dropdown
        var country = document.querySelector(this.config.country).value
        }
    
        // if page 0, remove any previous options
        if(page === 0){
        while (this.select.options.length > 1) {                
            this.select.remove(1)
        }
        }else{
        // remove the bottom 'next page' option
        this.select.remove(this.select.options.length - 1)
        }
    
        // fetch the json formatted result from Postcoder and pass it to processResult
        fetch(this.endpoint + country + '/' + searchterm + '?lines=' + this.addresslines + '&exclude=organisation,country&page=' + page)
        .then( response => {
            if (!response.ok) { 
            throw response 
            }
            return response.json()
        })
        .then( json => {
            this.processResult(json)
        })
        .catch( err => {
    
            if(typeof err.text === 'function'){
            err.text().then( errorMessage => {
                console.log('Postcoder request error ' + err.status + ' : ' + errorMessage)
            })
            }else{
                console.log(err)
            }
        })
    }
    
    processResult = addresses =>{
    
        this.addresses = addresses
    
        //if zero results, ask for manual address entry
        if( addresses.length === 0 ){
        
        //show the no result message
        this.noresultmessage.style.display = 'block'
    
        }
        // if one result, populate the form
        else if(addresses.length === 1){
    
        this.selectAddress(0)
    
        }
        // multiple addresses, show drop down to select from
        else{
    
        // create and append the address options, using the summaryline of the returned addresses
        for (let i = 0; i < addresses.length; i++) {
            let option = document.createElement('option')
            option.value = i
            option.text = addresses[i].summaryline
            this.select.appendChild(option)
        }
    
        // if there are morevalues, add paging
        if(this.addresses[this.addresses.length - 1]['morevalues'] === 'true'){
    
            // add a 'load next page' option
            let option = document.createElement('option')
            option.value = 'p' + this.addresses[this.addresses.length - 1]['nextpage']
    
            // last address contains total number of results, show the user how many are remaining
            let remainingresults = this.addresses[this.addresses.length - 1]['totalresults'] - this.select.options.length + 1
    
            option.text = 'Load more results, ' + remainingresults + ' of ' + this.addresses[this.addresses.length - 1]['totalresults'] + ' remaining'
            this.select.appendChild(option)
    
        }
        
        // ensure the select is visible
        this.select.style.display = 'block'
    
        }
    }
    
    selectAddress = i =>{
    
        // get the selected address
        let address = this.addresses[i]
    
        let fields = ['organisation','addressline1','addressline2','addressline3','addressline4','posttown','county','postcode']
    
        //populate the address form  
        for (let i = 0; i < fields.length; i++) {
        let field_selector = this.config[fields[i]]
        if(typeof field_selector !== 'undefined' && field_selector !== ''){
            document.querySelector(field_selector).value = (typeof address[fields[i]] !== 'undefined') ? address[fields[i]] : ''
        }
        }
    
    }  
}
    