// fetch('https://public-api.solscan.io/account/tokens')
fetch('https://public-api.solscan.io/account/tokens?account=9WzDXwBbmkg8ZTbNMqUxvQRAyrZzDsGYdLVL9zYtAWWM')
.then(res => res.json())
.then(data => console.log(data))

// let ab = data
// console.log(ab)





