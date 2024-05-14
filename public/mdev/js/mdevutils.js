/**
 * Remove all new lines characters ( \n and <br /> )
 * @param text
 * @return {*}
 * @private
 */
function _t(text) {
    return text.replace("\n", "").replace("<br />", "");
}

function randomId(length = 25) {
  let result = '';
  const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
  const charactersLength = characters.length;
  let counter = 0;
  while (counter < length) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
    counter += 1;
  }
  return result;
}

function verifyPassword(pwd1, pwd2){
    if(pwd1){
        if(pwd1 === pwd2){
            if (pwd1.length > 7) {
                if(pwd1.match(/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*$@%_.])([-+!*$@%_.\w]{8,55})$/m)){
                    return true;
                }else{
                    iziToastWarning("Votre mot de passe doit au moins contenir une lettre majuscule, une lettre miniscule, un chiffre, un caractère spécial ($@%*+-_!.)");
                }
            }else{
                iziToastWarning("Merci d'employer au moins 8 caractères pour votre mot de passe");
            }
        }else{
            iziToastWarning("Les deux mots de passe ne sont pas identiques");
        }
    }else{
        iziToastWarning("Veuillez ajouter un mot de passe");
    }
    return false;
}
function verifyPhoneNumber(number){
    if(!number){
        return true;
    }

    if(number.match(/^[\+]?[0-9]{3,4}?[0-9]{7,9}$/im)){
        return true;
    }
    iziToastWarning("Veuillez donner un numéro de téléphone valable commençant par l'identifiant du pays (ex. +41790123456 ou 0794274295)");
    return false;
}
function verifyEmail(email){
    if(!email){
        return true;
    }

    if(email.match(/^\S+@\S+\.\S+$/)){
        if(!email.match(/[éèàïäüùç*/+=()&%ç"'#|]/)){
            return true;
        }
        iziToastWarning("Veuillez donner une adresse email sans accent ou caractère spécial (ex. adresse@email.ch)");
        return false;
    }
    iziToastWarning("Veuillez donner une adresse email valable (ex. adresse@email.ch)");
    return false;
}

function showLoader() {
    $("#loader").show();
}
function hideLoader() {
    $("#loader").hide();
}

DropZoneManager = {

    getIconTypeByMime: function (mimeType) {

        if (mimeType in mimeTypeIcons) {
            return mimeTypeIcons[mimeType];
        }

        return mimeTypeIcons['default'];

    },

    deleteFile: function (fileId, baseFormId, dropZoneId, dropzone, file) {
        const baseForm = document.getElementById(baseFormId);
        if (dropZoneId !== undefined) {
            $(baseForm).find('.' + dropZoneId).find('input[id=' + fileId + ']').remove();
        } else {
            $(baseForm).find('.files-input').find('input[id=' + fileId + ']').remove();
        }

        $('.file-div-' + fileId).remove();
        dropzone.removeFile(file)
    },

    init: function (formId, baseFormId, dropZoneId) {
        let _this = this;
        const form = document.getElementById(formId);
        let dropzone = null;
        if (dropZoneId !== undefined) {
            dropzone = new Dropzone(document.getElementById(dropZoneId), {
                url: $(form).attr('action'),
                headers: {
                    'security': $(form).find('input[name="security"]').attr('value')
                },
                params: {
                    'csrf-token': $(form).find('input[name="csrf-token"]').attr('value')
                }
            });
        } else {
            dropzone = new Dropzone(form.querySelector(".dropzone-inside"), {
                url: $(form).attr('action'),
                headers: {
                    'security': $(form).find('input[name="security"]').attr('value')
                }
            });
        }

        dropzone.options.maxFilesize = 3;
        dropzone.options.maxFiles = 5;
        dropzone.options.acceptedFiles = 'image/jpeg, image/png, image/gif, image/tiff, application/msword, application/vnd.openxmlformats-officedocument.wordprocessingml.document, application/vnd.oasis.opendocument.spreadsheet, application/vnd.oasis.opendocument.text, application/pdf, application/rtf, application/vnd.visio, application/vnd.ms-excel, application/vnd.ms-office, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet';

        dropzone.on("error", function (file, errorMessage) {
            let message = $(file.previewElement).find('.dz-error-message');
            $(file.previewElement).find('.dz-size > img').remove();
            $(file.previewElement).find('.dz-details > .dz-size').remove();

            if(errorMessage.startsWith("File is too big")) {
                message.text(translatedText.errorFiles['fileUploadFileErrorIniSize']);
                iziToastWarning(translatedText.errorFiles.fileUploadFileErrorIniSize);
            } else if(errorMessage.startsWith("You can't upload files")) {
                message.text(translatedText.errorFiles['fileMimeTypeFalse']);
                iziToastWarning(translatedText.errorFiles.fileMimeTypeFalse);
            } else {
                message.text(translatedText.errorFiles['default']);
                console.log(errorMessage);
            }

            mdevUtils.appendFileHTMLElement(file, null, baseFormId, dropZoneId, dropzone);
        });

        dropzone.on("addedfile", function (file) {
            const loader = $(file.previewElement).find('.dz-size');
            const loadingImage = '<img class="file-upload-loader" src=' + loaderPath + '>';
            loader.append(loadingImage);

        });


        dropzone.on("success", function (file, data) {
            const message = $(file.previewElement).find('.dz-error-message');
            $(file.previewElement).find('.dz-size > img').remove();
            $(file.previewElement).find('.dz-details > .dz-size').remove();

            mdevUtils.appendFileHTMLElement(file, data, baseFormId, dropZoneId, dropzone);

            if(data.success && mdevUtils.checkIfDuplicate(baseFormId, file, data.fileRef) === true){
                const message = $(file.previewElement).find('.dz-error-message');
                message.text(translatedText.errorFiles.fileAlreadyAdded);
            }
            else if (data.success === false) {
                if (data.message.file.fileMimeTypeFalse) {
                    message.text(translatedText.errorFiles.fileMimeTypeFalse);
                    iziToastWarning(translatedText.errorFiles.fileMimeTypeFalse);
                } else if (data.message.file.fileUploadFileErrorIniSize) {
                    message.text(translatedText.errorFiles.fileUploadFileErrorIniSize);
                    iziToastWarning(translatedText.errorFiles.fileUploadFileErrorIniSize);
                } else {
                    message.text(translatedText.errorFiles['default']);
                    iziToastWarning(translatedText.errorFiles['default']);
                }
            }
            else{
                mdevUtils.appendFileInputElement(file, data, dropZoneId);
            }

        });

        dropzone.on("maxfilesexceeded", function(file){
            dropzone.removeFile(file)
            iziToastWarning(translatedText.errorFiles['fileLimitReached']);
        });

        return dropzone;
    }
};
var mdevUtils = {

    /**
     * Format a text by defining blocs of characters and how to display them in the outcome.<br>
     *     <b><u>sourceFormat</u></b><br>
     *     Defines the formatting blocks. A group of the same letter represent a block : 'hh:mm' forms the blocks 'hh', '.' and 'mm'.<br>
     *     The values of the blocks consist of the corresponding letters in the text, by order. '14:26' and 'hh:mm' form the blocks
     *     'hh' = '14', ':' = ':' and 'mm' = '26'.<br>
     *     The number of characters per block is important : you can define any number of blocks using the same letter as long as each block
     *     has a different number of characters. 'ddd.dd.d' forms the blocks 'ddd', '.', 'dd' and 'd'.<br>
     *     NOTE: If a block is used many times, its value will be set to its last reference. '14:26' and 'xx:xx' form the blocks
     *     'xx' = '26' and ':' = ':'.<br>
     *     The letters used to form the blocks have no impact on the execution : 'hh:mm' could be written '11233'.<br>
     *     The wildcard '\*' can be used to match an unknown number of character. When using '\*' in the sourceFormat, except if used as the last character, the letter
     *     that follows '\*' defines the end of the match and must represent an existing character in the text : with the text '123456789' and format '\*7yy', the block
     *     '\*' will have the value '123456' (as '\*' is followed by '7', the match for '\*' ends when a '7' is found in the text).<br>
     *     The wildcard '\*' can be used multiple times as long as a different number of characters are used (as the other blocks) :
     *     '123456.7890' and '\*.\*\*' forms the blocks '\*' = '123456', '.' = '.' and '\*\*' = '7890'.<br>
     *     Instead of using multiple '\*' to differentiate '\*' blocks, a name can be set for each '\*' blocks using '{name}' directly after a '\*' :
     *     '123456.7890' and '\*{integers}.\*{decimals}' forms the blocks 'integers' = '123456', '.' = '.' and 'decimals' = '7890'. The name is then used as block's
     *     reference in destination format.<br>
     *     The sourceFormat can be passed as an array of sourceFormat. In that case it will select the first sourceFormat that has a length that fit the
     *     length of the text (taking '\*' into account), or the first if none correspond.
     *     <br>
     *     <b><u>destFormat (destination format)</u></b><br>
     *     Defines the outcome by re-ordering the blocks.<br>
     *     Any match with the blocks defined in the sourceFormat will use the value corresponding to the matched block.<br>
     *     If the sourceFormat is an array, the destFormat can be passed as an array too. In that case it will select the destFormat at
     *     the same index that the sourceFormat (or the first if none correspond).
     *     <br>
     *     <b><u>callback</u></b><br>
     *     A function that gives the blocks and their values as an Object of 'block: value'.<br>
     *     The blocks' value can be modified directly and blocks can be added to the object.<br>
     *     The function can return a string to override the destFormat if needed.<br>
     *     <br>
     *     <b><u>Examples</u></b><br>
     *     <ul>
     *     <li>Numbers</li>
     *         <ol>
     *              <li>format("12,34", "xx,yz", "xx.y") outcome : "12.3"<</li>
     *              <li>format("12,34", "xx,yz", "CHF xx.-") outcome : "CHF 12.-"</li>
     *         </ol>
     *     <li>Dates</li>
     *         <ol>
     *              <li>format("07/02/23", "dd/mm/yyYY", "mm-dd-yyYY") outcome : "02-07-23"</li>
     *              <li>format("07/02/23", "dd/mm/yyYY", "The dd.mm of yyYY") outcome : "The 07.02 of 2023"<</li>
     *         </ol>
     *     <li>Multiple sources to single format</li>
     *        <ol>
     *              <li>format("07/02/23", ["dd/mm/YY", "dd/mm/yyYY", "yyYY-02-07Thh:mm:ss"], "mm.dd.YY") outcome : "07.02.23"</li>
     *              <li>format("07/02/2023", ["dd/mm/YY", "dd/mm/yyYY", "yyYY-02-07Thh:mm:ss"], "mm.dd.YY") outcome : "07.02.23"</li>
     *              <li>format("2023-02-07T15:00:00", ["dd/mm/YY", "dd/mm/yyYY", "yyYY-mm-ddThh:MM:ss"], "mm.dd.YY") outcome : "07.02.23"</li>
     *        </ol>
     *     <li>Multiple sources to different formats</li>
     *         <ol>
     *              <li>format("02/07/23", ["mm/dd/yy", "mm/dd/yyyy"], ["mm-yy", "dd.mm.yyyy"]) outcome : "02-23"</li>
     *             <li>format("02/07/2023", ["mm/dd/yy", "mm/dd/yyyy"], ["mm-yy", "dd.mm.yyyy"]) outcome : "07.02.2023"</li>
     *          </ol>
     *      </ul>
     *
     * @param {string} text
     * @param {string|string[]} sourceFormat
     * @param {string|string[]} destFormat
     * @param {callback} callback
     * @return {string}
     */
     formatString : function(text, sourceFormat, destFormat, callback = () => {}) {

        /* CHOOSING AN ADEQUATE SOURCE FORMAT*/
        if (sourceFormat instanceof Array) {
            let sourceFormatIndex = sourceFormat.findIndex(sf => {

                /*
                    The source format is adequate if it's length correspond to the text length.
                 */

                if (sf.includes("*")) {

                    /*
                        We need to check if the source format length equals the text length taking the '*' in
                        account.
                        Starting from 0, we increment an index on the sourceFormat and one on the text for each
                        letter matched.
                     */
                    let textIndex, sfIndex;
                    for (textIndex = 0, sfIndex = 0; textIndex < text.length && sfIndex < sf.length; textIndex++, sfIndex++) {

                        if (sf[sfIndex] === "*") {

                            /* ignore the {name} part if set */
                            if (sf[sfIndex+1] === "{" ) {
                                while (sf[sfIndex] !== "}" &&  sfIndex+1 < sf.length) {
                                    sfIndex++;
                                }
                            }

                            /*
                                When '*{}' is the last block of the source format : the remaining text is no longer
                                important : the source format is adequate !
                            */
                            if (sfIndex+1 >= sf.length) {
                                return true;
                            }

                            sfIndex++;

                            /* Incrementing the text index */
                            while (text[textIndex] !== sf[sfIndex] && textIndex <= text.length) {
                                textIndex++;
                            }
                        }
                    }

                    /* When '*' or '*{}' is the last block fo the source format and is not included in the text */
                    if (sf[sfIndex] === '*') {

                        /* ignore the {name} part if set */
                        if (sf[sfIndex+1] === "{" ) {
                            while (sf[sfIndex] !== "}" &&  sfIndex+1 < sf.length) {
                                sfIndex++;
                            }
                        }

                        if (sfIndex+1 >= sf.length) {
                            sfIndex = sf.length;
                        }
                    }

                    return textIndex === text.length && sfIndex === sf.length;
                }
                else
                    return text.length === sf.length;
            });

            /* When no adequate source format is found we use the first one */
            if (sourceFormatIndex === -1)
                sourceFormatIndex = 0;

            sourceFormat = sourceFormat[sourceFormatIndex];

            /* CHOOSING AN ADEQUATE SOURCE FORMAT*/
            if(destFormat instanceof Array) {

                /*
                    If the destFormat is an array, we choose the same index as the sourceFormat,
                    or the first one if none found
                */
                if (sourceFormatIndex < destFormat.length)
                    destFormat = destFormat[sourceFormatIndex];
                else
                    destFormat = destFormat[0];
            }
        }

        /* CONSTRUCTING THE SOURCE BLOCKS */

        const sourceBlocks = {};
        const namedBlocks = [];

        let previousLetter = sourceFormat[0];
        let block = {key: "", value: ""};

        for (let textIndex = 0, sfIndex = 0; sfIndex <= sourceFormat.length; textIndex++, sfIndex++) {

            const sfLetter = sourceFormat[sfIndex];

            if(sfLetter === "*") {

                /* End of previous block */
                sourceBlocks[block.key] = block.value;

                let blockKey = "*";
                if (sourceFormat[sfIndex+1] === "{") {
                    sfIndex += 2;
                    blockKey = "";
                    while (sourceFormat[sfIndex] !== "}" &&  sfIndex+1 < sourceFormat.length) {
                        blockKey += sourceFormat[sfIndex];
                        sfIndex++;
                    }
                    namedBlocks.push(blockKey);
                }


                block = {key: blockKey, value: ""}

                /* When '*' is the last chars of the source format : we add all the remaining text in the block. */
                if (sfIndex+1 >= sourceFormat.length) {
                    block.value = text.substring(textIndex);
                }
                else {
                    /* Adding to block's while it doesn't match the letter following the '*' block */
                    while (text[textIndex] !== sourceFormat[sfIndex+1] && textIndex < text.length && sfIndex+1 < sourceFormat.length) {
                        block.value += text[textIndex];
                        textIndex++;
                    }
                    textIndex--; // When the match happened we were ahead of the text index
                }
            }
            else if(sfLetter === previousLetter) {
                /* Same block */
                block.key += sfLetter;
                block.value += text[textIndex];
            }
            else {
                /* End of previous block */
                sourceBlocks[block.key] = block.value;

                block = {key: sfLetter, value: text[textIndex]};
            }

            previousLetter = sfLetter;
        }

        /* CALLBACK FUNCTION BEFORE CONSTRUCTING THE OUTCOME */
        destFormat = callback(sourceBlocks) ?? destFormat;


        /* CONSTRUCTING THE DESTINATION BLOCKS */

        const destBlocks = [];

        /* construct the named blocks */
        namedBlocks.forEach((blockName, i) => {
            const delta = String(i);
            let key = delta;
            while (sourceBlocks[key]) {
                key += delta;
            }
            block = {key: key};
            while (destFormat.indexOf(blockName) !== -1) {
                destFormat = destFormat.replace(blockName, key);
            }
            sourceBlocks[key] = sourceBlocks[blockName];
        });

        previousLetter = destFormat[0];
        block = {key: destFormat[0]};
        for (let i = 1; i <= destFormat.length; i++) {
            const currentLetter = destFormat[i];
            if (currentLetter === previousLetter) {
                /* Same block */
                block.key += currentLetter;
            }
            else {
                /* End of previous block */
                destBlocks.push(block);
                block = {key:currentLetter};
                previousLetter = currentLetter;
            }
        }

        /* CONSTRUCTING THE OUTCOME */

        let result = "";
        destBlocks.forEach(block => {
            if (sourceBlocks[block.key] !== undefined) // Can't use simple check 'if(var)' as some block could have the key ' '
                result += sourceBlocks[block.key];
            else
                result += block.key;
        });

        return result;
    },

    /**
     * This method add the file HTML element to the form with the file icon and delete icon.
     *
     * @param file - The file HTML element returned by a dropZone event.
     * @param data - The data returned by the on success dropZone event. If null, the file HTML element is still added.
     * @param baseFormId - the base form HTML ref.
     * @param dropZoneId - The drop zone HTML ref.
     * @param dropzone
     */
    appendFileHTMLElement: function (file, data, baseFormId, dropZoneId, dropzone){

        let fileRef;

        // Creating file ref is none bound to data
        if (data == null || data.fileRef === undefined){ // Generate file ref using timestamp
            fileRef = Date.now();

            // Ensuring unique ref in case multiple file are uploaded at the same time
            while(document.getElementById(fileRef) != null){
                fileRef++;
            }
        }
        else
            fileRef = data.fileRef;

        const fileName = $(file.previewElement).find('.dz-filename');
        const icon = DropZoneManager.getIconTypeByMime(file.type);
        const fileNameToWrite = '<i style="margin-right: 6px;color:' + icon.color + '" class="' + icon.icon + '"></i>';
        fileName.prepend(fileNameToWrite);

        $(file.previewElement).addClass("file-div-" + fileRef);

        const details = $(file.previewElement).find('.dz-details');
        DrawerManager.create('i', details, 'fa fa-trash pull-right trash-file', function () {
            DropZoneManager.deleteFile(fileRef, baseFormId, dropZoneId, dropzone, file)
        });
    },
    /**
     * This method check if there is a duplicate of the file in the dropzone elements.
     *
     * @param formId - The id of the form element.
     * @param file - The added file, returned by the dropzone events.
     * @param fileRef - The file reference, returned by the dropzone on success event. Needed to ignore self-comparing.
     * @returns {boolean}
     */
    checkIfDuplicate: function(formId, file, fileRef) {

        // Get dropzone parent element
        const dropzoneElement = document
            .getElementById(formId)
            .querySelector('div[class*=file-div-' + fileRef + ']')
            .parentElement;

        // Check each files in dropzone
        for (let fileElement of dropzoneElement.children) {

            // Ignore itself
            if(!$(fileElement).hasClass("file-div-" + fileRef)){

                let nameElement = fileElement.querySelector('span[data-dz-name]');

                // Ensure it works with the alternates elements
                if (nameElement.querySelector('a') != null)
                    nameElement = nameElement.querySelector('a');


                if (file.name == nameElement.innerText)
                    return true;
            }
        }

        return false;
    },
    /**
     * This method add the file input element to the form.
     *
     * @param data - The data returned by the on success dropZone event. If null, no input element is added.
     * @param inputDivRef - The div HTML ref where to add the input.
     */
    appendFileInputElement: function (file, data, inputDivRef){

        if (data == null || data.fileRef === undefined)
            return;

        const fileRef = data.fileRef;
        const fileName = data.file.name;
        const fileType = data.file.type;
        const fileTempName = data.file.tempName;
        const fileError = data.file.error;
        const fileSize = data.file.size;

        if(inputDivRef !== undefined){
            const name = inputDivRef.substring(0, inputDivRef.length - 6);
            let fileInput = '<input type="hidden" name="' + name + '[]" id="' + fileRef + '" value="' + fileRef + '" ' +
                ' fileName="' + fileName + '" fileType="' + fileType + '" fileTempName="' + fileTempName + '" fileError="' + fileError + '" fileSize="' + fileSize + '">';
            $('.' + inputDivRef).append(fileInput);
        }
        else{
            let fileInput = '<input type="hidden" name="files[]" id="' + fileRef + '" value="' + fileRef + '">';
            $('.files-input').append(fileInput);
        }
    },

    createPieChart: function(dom, dataSeries, title){
        dom.setAttribute("style", "height:200px;");
        dom.setAttribute("_echarts_instance_", "");

        let myChart = echarts.init(dom)
        option = {
            title: {
                text: title,
                left: 'center',
                textStyle: {fontSize: '15',}
            },
            tooltip: {
                trigger: 'item',
                formatter: function(params) {
                    return params.data.name + " : " + params.data.info;
                }
            },
            legend: {
                orient: 'vertical',
                selectedMode: false,
                right: 'right',
                top: 35,
                textStyle: {
                    lineHeight: 16,
                },
                formatter: name => {
                    var series = myChart.getOption().series[0];
                    var legend = series.data.filter(row => row.name === name)[0].legend
                    return name + "\n" + legend;
                },
            }
            ,
            series: [
                {
                    name: '',
                    type: 'pie',
                    radius: '75%',
                    center: ['30%', '55%'],
                    label:{show:false},
                    hoverOffset: 2,
                    data: dataSeries,
                }
            ]
        };
        if (option && typeof option === "object") {
            myChart.setOption(option, true);
        }
    },

    createChart: function (dom, dataHeader, dataSeries, title){
        let chartHeight = (dataHeader.length*30)+150;
        chartHeight = chartHeight >= 250 ? chartHeight : 250;
        dom.setAttribute("style", "height:"+chartHeight+"px;");
        dom.setAttribute("_echarts_instance_", "");

        let myChart = echarts.init(dom)
        option = {
            title: {
                text: title,
                left: 'center',
                textStyle: {fontSize: '15',}
            },
            tooltip: {
                trigger: 'item',
                formatter: ' {b}:  {c} '
            },
            grid: {containLabel: true},
            xAxis: {name: '',
                splitLine : {
                    show : true,
                    lineStyle : {
                        color : '#C0C0C0'
                    }
                }},
            yAxis: {
                type: 'category',
                data: dataHeader
            },
            visualMap: {
                show: false,
                min: 1,
                max: 25,
                dimension: 0,
                inRange: {
                    color: ['#3392b7']
                }
            },
            series: [
                {
                    type: 'bar',
                    data: dataSeries,
                    encode: {
                        // Map the "amount" column to X axis.
                        x: 'value',
                        // Map the "product" column to Y axis
                        y: 'type'
                    },
                }
            ]
        };
        if (option && typeof option === "object") {
            myChart.setOption(option, true);
        }
    },

    createHourChart: function(dom, dataHeader, dataSeries, title, markLine = null){
        let chartHeight = (dataHeader.length*30)+150;
        chartHeight = chartHeight >= 250 ? chartHeight : 250;
        dom.setAttribute("style", "height:"+chartHeight+"px;");
        dom.setAttribute("_echarts_instance_", "");

        let myChart = echarts.init(dom)
        option = {
            title: {
                text: title,
                left: 'center',
                textStyle: {fontSize: '15',}
            },
            tooltip: {
                trigger: 'item',
                formatter: function(params) {
                    return params.data.average;
                }
            },
            grid: {containLabel: true},
            xAxis: {name: '',
                splitLine : {
                    show : true,
                    lineStyle : {
                        color : '#C0C0C0'
                    }
                },
                axisLabel: {
                    formatter: (function(value){
                        return String(Math.floor(value/60)).padStart(2, '0') + "h" + String(value%60).padStart(2, '0');
                    })
                }
            },
            yAxis: {
                type: 'category',
                data: dataHeader
            },
            visualMap: {
                show: false,
                min: 1,
                max: 25,
                dimension: 0,
                inRange: {
                    color: ['#3392b7']
                }
            },
            series: [
                {
                    type: 'bar',
                    data: dataSeries,
                    encode: {
                        // Map the "amount" column to X axis.
                        x: 'value',
                        // Map the "product" column to Y axis
                        y: 'type'
                    },
                    markLine: markLine,
                }
            ]
        };
        if (option && typeof option === "object") {
            myChart.setOption(option, true);
        }
    },
}
