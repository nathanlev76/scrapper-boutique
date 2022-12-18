const { all } = require('axios');
const { JSDOM } = require('jsdom');
const fs = require('fs/promises');
const fssync = require('fs');



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

async function createJson(){
  const allProductsArray = []
  for (let i = 1; i < 9; i++) {
    response = await fetch(`http://vps-a47222b1.vps.ovh.net:8484/product/page/${i}`)
      //.then(response => response.text())
      //.then(data => {
        const html = await response.text();
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
          tag = getXPath(`/html/body/div/main/div/div[${nb}]/div/span`, document, 5)[0]
          nb+=1
          allProductsArray.push({id: idproduct, name: name, price: price, tag: tag, img: imgurl, page: page})
        });
        var productsJson = JSON.stringify(allProductsArray);
        await fs.writeFile("products.json", productsJson)
        var nbtest = 0
    };

    const data = fssync.readFileSync('products.json', 'utf8');
    jsondata = JSON.parse(data)
    const allProductsArray2 = []
    jsondata.forEach(elem => {
      const idproduct = elem["id"]
      const name = elem["name"]
      const price = elem["price"]
      const tag = elem["tag"]
      const img = elem["img"]
      const page = elem["page"]

      fetch(`http://vps-a47222b1.vps.ovh.net:8484/product/${elem["id"]}`)
      .then(response => response.text())
      .then(response => {
        const dom = new JSDOM(response);
        const document = dom.window.document;
        description = getXPath(`/html/body/div/main/div/div/p`, document, 5)[0]
        allProductsArray2.push({id: idproduct, name: name, price: price, tag: tag, img: img, page: page, description: description})
        var productsJson = JSON.stringify(allProductsArray2);
        fs.writeFile("products.json", productsJson) 
      })
      .catch(error => console.log("Erreur : " + error));
    })  
}
  

createJson()
