var DrawerManager = {
    create: function( elementTag, parentElement, classes, clickCallback, eventType ){
        if(elementTag == undefined){
            throw new Error("le tag est obligatoire");
        }

        const newElement = document.createElement(elementTag);
        if(classes != undefined){
            newElement.setAttribute("class", classes);
        }
        if(parentElement != undefined){
            parentElement.append(newElement);
        }
        if(clickCallback != undefined && eventType === undefined){
            newElement.addEventListener("click", clickCallback);
        } else if (clickCallback != undefined) {
            newElement.addEventListener(eventType, clickCallback);
        }
        return newElement;
    },
};
