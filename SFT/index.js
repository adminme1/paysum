// fetch('https://public-api.solscan.io/account/tokens')

//Bangladesh
fetch('https://public-api.solscan.io/account/tokens?account=9WzDXwBbmkg8ZTbNMqUxvQRAyrZzDsGYdLVL9zYtAWWM')
.then(res => res.json())
.then((data) => {
	const ustd = data.find(token => token.tokenName=="USDT");
	console.log(ustd);
	document.getElementById('bdPoolAmount').innerHTML = ustd.tokenName+" "+ ustd.tokenAmount.amount;
})

// let ab = data
// console.log(ab)





