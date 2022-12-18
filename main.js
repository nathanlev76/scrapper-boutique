const { all } = require('axios');
const { JSDOM } = require('jsdom');
const fs = require("fs")

const allProductsArray = []

function getXPath(xpath, document, searchtype){
  const h1 = document.evaluate(xpath, document, null, searchtype, null); 
  const listetexte = []
  let thisHeading = h1.iterateNext();
  while (thisHeading) {
    listetexte.push(thisHeading.textContent)
    thisHeading = h1.iterateNext();
  }
  return(listetexte)
}

for (let i = 1; i < 9; i++) {
  fetch(`http://vps-a47222b1.vps.ovh.net:8484/product/page/${i}`)
    .then(response => response.text())
    .then(data => {
      const html = data;
      const dom = new JSDOM(html);
      const document = dom.window.document;
      var nb = 1

      result = getXPath("/html/body/div/main/div/div/div/h5", document, 5)
      result.forEach(elem => {
        var splitname = elem.split(" - ")
        var name = splitname[0]
        var price = splitname[1]
        var page = i
        imgurl = getXPath(`/html/body/div/main/div/div[${nb}]/img/@src`, document, 5)[0]
        idproduct = getXPath(`/html/body/div/main/div/div[${nb}]/div/a/@href`, document, 5)[0]
        idproduct = idproduct.replace("/product/", "");
        nb+=1
        allProductsArray.push({id: idproduct, name: name, price: price, img: imgurl, page: page})
      });

      var productsJson = JSON.stringify(allProductsArray);

      fs.writeFile("products.json", productsJson, (err) => {
        if (err)
          console.log(err);
        else {
          console.log(`${nb-1} produits de la page ${i} ont été récupérés et stockés avec succès !`);
        }
      });
    })

    .catch(error => {
      console.log(error)
  });
}