//////////r-slider.js//////////////
class Slider extends React.Components {
    constructor(props){
        super(props);
        this.state = {
            container:this.props.container,
            range:this.props.end - this.props.start,
            min:(this.props.min === undefined || this.props.min < this.props.start)?this.props.start:this.props.min,
            max:(this.props.max === undefined || this.props.max > this.props.end)?this.props.end:this.props.max,
            value : this.getValue(this.props.value),
            styleName : this.getStyleName(),
            style : this.getStyle(this.props.style),
            text : this.props.text || [],
            step: this.props.step || 1,
            changable: this.props.changable === undefined?true:this.props.changable,
            direction: this.props.direction || "right",
            showFill: this.props.showFill===undefined?true:this.props.showFill, 
            showButton: this.props.showButton===undefined?true:this.props.showButton
        }
        this.buttonmousedown = this.buttonmousedown.bind(this);
        this.spacemousedown = this.spacemousedown.bind(this);
        this.labelmousedown = this.labelmousedown.bind(this);
        
    }
    
    getValue(value) {
        var min = this.state.min, max = this.state.max;
        if (value === undefined) { value = [min]; }
        if (typeof value === "number") { value = [value]; }
        for (var i = 0; i < value.length; i++) { if (value[i] > max) { value[i] = max; } else if (value[i] < min) { value[i] = min; } }
        return value;
    }
        
    getStyleName() {
        var d = this.state.direction;
        if (d === "right") { return { Thickness: "width", Thickness_r: "height", OtherSide: "top", OtherSide_r: "bottom", Axis: "x", Sign: 1, StartSide: "left", EndSide: "right", } }
        else if (d === "left") { return { Thickness: "width", Thickness_r: "height", OtherSide: "top", OtherSide_r: "bottom", Axis: "x", Sign: -1, StartSide: "right", EndSide: "left", } }
        else if (d === "down") { return { Thickness: "height", Thickness_r: "width", OtherSide: "left", OtherSide_r: "right", Axis: "y", Sign: 1, StartSide: "top", EndSide: "bottom", } }
        else if (d === "up") { return { Thickness: "height", Thickness_r: "width", OtherSide: "left", OtherSide_r: "right", Axis: "y", Sign: -1, StartSide: "bottom", EndSide: "top", } }
    }
    getStyle(obj) {
        var style = { button_width: 10, button_height: 10, line_width: 2, margin: 0, }, thickness = this.state.styleName.Thickness,
        container = $(this.state.container);
        if (style["button_" + thickness] > container[thickness]()) { style["button_" + thickness] = container[thickness]() }
        if (obj === undefined) { return style; }
        for (prop in obj) { style[prop] = obj[prop]; }
        return style;
    }
    getClient(e, axis) { if (e["client" + axis]===undefined) { return e.changedTouches[0]["client" + axis]; } else { return e["client" + axis]; } }
    getValueByClick(e) {
        var calc = new RSliderCalculator(this.state), d = this.state.direction, x = this.getClient(e, "X"), y = this.getClient(e, "Y");
        var inner = $(this.state.container).find(".r-slider-container");
        if (d === "right") { var distance = x + pageXOffset - inner.offset().left; }
        else if (d === "left") { var distance = inner.offset().left + this.width - x - pageXOffset; }
        else if (d === "down") { var distance = y + pageYOffset - inner.offset().top; }
        else if (d === "up") { var distance = inner.offset().top + this.height - y - pageYOffset; }
        return calc.getCorrectValue(calc.getValueByPixel(distance));
    }
    move(dir) {
        var s = this.state, buttons = $(s.container).find(".r-slider-button");
        for (var i = 0; i < s.value.length; i++) { this.moveButtonTo(buttons.eq(i), s.step * dir, true); }
        if (s.ondrag !== undefined) { s.ondrag(s); }
    }
    spacemousedown(e) {
        e.preventDefault();
        this.setWidthHeight();
        var s = this.state, container = $(s.container), element = $(e.currentTarget), index = element.data("index");
        container.find(".r-slider-button").css({ "zIndex": 1000 });
        container.find(".r-slider-button[data-index=" + index + "]").css({ "zIndex": 10000 });
        if (index === 0) { this.move(-1); } //اگر روی فضای خالی ابتدا کلیک شد
        else if (index === s.value.length) { this.move(1); } //اگر روی فضای خالی انتها کلیک شد
        else {
            var button = container.find(".r-slider-button[data-index=" + index + "]");
            var button_b = container.find(".r-slider-button[data-index=" + (index - 1) + "]");
            var value = s.value[index];
            var value_b = s.value[index - 1];
            var diffrence = Math.abs(value - value_b);
            s.startOffset = {
                x: this.getClient(e, "X"), y: this.getClient(e, "Y"), value: value, value_b: value_b, button: button, button_b: button_b,
                limit: {
                    before: {
                        min: s.value[index - 2] === undefined ? s.start : s.value[index - 2],
                        max: s.value[index + 1] === undefined ? s.end - diffrence : s.value[index + 1] - diffrence
                    },
                    current: {
                        min: s.value[index - 2] === undefined ? s.start + diffrence : s.value[index - 2] + diffrence,
                        max: s.value[index + 1] === undefined ? s.end : s.value[index + 1]
                    }
                },
            };
            this.eventHandler("window", "mousemove", this.spacemousemove);
        }
        container.find(".r-slider-number").show();
        this.eventHandler("window", "mouseup", this.mouseup);
    }
    buttonmousedown(e) {
        e.preventDefault();
        this.setWidthHeight();
        var s = this.state, container = $(s.container), element = $(e.currentTarget), index = element.data("index");
        container.find(".r-slider-button").css({ "zIndex": 1000 });
        container.find(".r-slider-button[data-index=" + index + "]").css({ "zIndex": 10000 });
        s.startOffset = {
            x: this.getClient(e, "X"), y: this.getClient(e, "Y"), value: s.value[index], button: container.find(".r-slider-button[data-index=" + index + "]"),
            limit: {
                min: s.value[index - 1] === undefined ? s.start : s.value[index - 1],
                max: s.value[index + 1] === undefined ? s.end : s.value[index + 1],
            },
        };
        this.eventHandler("window", "mousemove", this.buttonmousemove);
        container.find(".r-slider-number").show();
        this.eventHandler("window", "mouseup", this.mouseup);
        if (s.onbuttonmousedown !== undefined) { s.onbuttonmousedown(s); }
    }
    labelmousedown (e) {
        if (this.state.value.length !== 1 || !this.state.changable) { return; }
        var value = parseFloat($(e.currentTarget).find("span").html());
        this.update({ value: value });
    }
    buttonmousemove(e) {
        var s = this.state, calc = new RSliderCalculator(s), so = s.startOffset, axis = s.styleName.Axis, change;
        var offsetValue = calc.getValueByPixel((this.getClient(e, axis.toUpperCase()) - so[axis]) * s.styleName.Sign);
        var value = calc.getCorrectValue(offsetValue + so.value);
        if (value < so.limit.min) { value = so.limit.min; }
        if (value > so.limit.max) { value = so.limit.max; }
        change = this.moveButtonTo(so.button, value, false);
        if (s.ondrag !== undefined && change) { s.ondrag(s); }
    }
    spacemousemove(e) {
        var s = this.state, calc = new RSliderCalculator(s), so = s.startOffset, axis = s.styleName.Axis, change;
        var offsetValue = calc.getValueByPixel((this.getClient(e, axis.toUpperCase()) - so[axis]) * s.styleName.Sign);
        var value = calc.getCorrectValue(offsetValue + so.value);
        var value_b = calc.getCorrectValue(offsetValue + so.value_b);
        if (value_b < so.limit.before.min) { value_b = so.limit.before.min; }
        if (value_b > so.limit.before.max) { value_b = so.limit.before.max; }
        if (value < so.limit.current.min) { value = so.limit.current.min; }
        if (value > so.limit.current.max) { value = so.limit.current.max; }
        change = this.moveButtonTo(so.button, value, false);
        this.moveButtonTo(so.button_b, value_b, false);
        if (s.ondrag !== undefined && change) { s.ondrag(s); }
    }
    mouseup() {
        var s = this.state;
        if (s.fixValue !== true) { $(s.container).find(".r-slider-number").fadeOut(100); }
        this.eventRemover("window", "mousemove", this.mousemove);
        this.eventRemover("window", "mouseup", this.mouseup);
        if (s.onchange !== undefined) { s.onchange(s); }
    }
    setWidthHeight() {
        var s = this.state, inner = $(s.container).find(".r-slider-container");
        s.width = inner.width(); s.height = inner.height();
    }
    moveButtonTo(button, value, offset) {
        var s = this.state, calc = new RSliderCalculator(s);
        if (offset === true) {
            if (value === 0) { return false; }
            value += parseFloat(button.attr("data-value"));
        }
        if (parseFloat(button.attr("data-value")) === value) { return false; }
        var index = button.data("index");
        var sn = s.styleName;
        var percent = calc.getPercentByValue(value);
        var percent_b = calc.getPercentByValue(s.value[index - 1]) || 0;
        var percent_a = calc.getPercentByValue(s.value[index + 1]) || 100;
        var container = $(s.container);
        var space = container.find(".r-slider-space[data-index=" + (index) + "]");
        var space_a = container.find(".r-slider-space[data-index=" + (index + 1) + "]");
        var style = s.style;
        var size = style['button_' + sn.Thickness];
        button.css(sn.StartSide, 'calc(' + percent + '% - ' + (size / 2) + 'px');
        space.css(sn.Thickness, (percent - percent_b) + '%');
        space_a.css(sn.Thickness, (percent_a - percent) + '%');
        space_a.css(sn.StartSide, percent + '%');
        s.value[index] = value;
        button.attr("data-value", value);
        button.find(".r-slider-number").html(value);
        return true;
    }
    /////////get template////////////////////
    getcontainerstyle() {
        var s = this.state, sn = s.styleName, size = s.style['button_' + sn.Thickness], size_r = s.style['button_' + sn.Thickness_r], str = 'position:absolute;';
        //str += 'background:red;opacity:0.3;';
        str += sn.StartSide + ':' + ((size / 2) + s.style.margin) + 'px;';
        str += sn.OtherSide + ':calc(50% - ' + (size_r / 2) + 'px);';
        str += sn.Thickness + ':calc(100% - ' + (size + (s.style.margin * 2)) + 'px);';
        str += sn.Thickness_r + ':' + size_r + 'px;';
        return str;
    }
    render() {
        var s = this.state, container = $(this.state.container), calc = new RSliderCalculator({ start: s.start, range: s.range });
        var elements = [];
        var length = s.value.length;
        for (var i = 0; i < length; i++) {
            elements.push(<RSSpace mouseDown={this.spacemousedown} showFill={s.showFill} index={i} value={s.value} style={s.style} styleName={s.styleName} text={s.text[i]} calc={calc} direction={s.direction} />);
            if (s.showButton !== false) {
                elements.push(<RSButton mouseDown={this.buttonmousedown} index={i} value={s.value} style={s.style} styleName={s.styleName} calc={calc} fixValue={s.fixValue} showValue={s.showValue} colors={s.colors} />);
            }
        }
        elements.push(<RSSpace showFill={s.showFill} index={length} value={s.value} style={s.style} styleName={s.styleName} text={s.text[length]} calc={calc} direction={s.direction} />);
        return(
            '<div className="r-slider-container" style={this.getcontainerstyle()}>'+
            '<RSPins start={s.start} end={s.end} styleName={s.styleName} calc={calc} pinStep={s.pinStep} />'+
            '<RSLabels mouseDown={this.labelmousedown} start={s.start} end={s.end} calc={calc} styleName={s.styleName} labelStep={s.labelStep} />'+
            '<RSLine style={s.style} styleName={s.styleName} />'+
            '</div>'
        );   
    }
}

function RSliderCalculator(obj) {
    var a = {
        state: {},
        init: function (obj) { for (prop in obj) { this.state[prop] = obj[prop]; } },
        getPercentByValue: function (value) {
            if (value === undefined) { return undefined; }
            return 100 * (value - this.state.start) / (this.state.range) || 0;
        },
        getPercentByPixel: function (px) { return Math.round(px * 100 / this.state[this.state.styleName.Thickness]); },
        getValueByPercent: function (percent) { return ((this.state.range / 100) * percent) + this.state.start; },
        getValueByPixel: function (px) { return (px * this.state.range) / this.state[this.state.styleName.Thickness]; },
        getCorrectValue: function (value) {
            value = (Math.round((value - this.state.start) / this.state.step) * this.state.step) + this.state.start;
            if (value < this.state.min) { value = this.state.min; }
            else if (value > this.state.max) { value = this.state.max; }
            value = parseFloat(value.toFixed(2));
            return value;
        },
    }
    a.init(obj);
    return a;
}
//calc-pinStep-start-end-styleName
class RSPins extends React.Components {
    constructor(props){
        super(props);
    }
    
    render(){
        if (!this.props.pinStep) { return ""; }
        var value = this.props.start;
        var str = [];
    while (value <= this.props.end) {
        var percent = this.props.calc.getPercentByValue(value);
        value += this.props.pinStep;
        str.push(<RSPin styleName={this.props.styleName} percent={percent} />);
    }
    return (
        <React.Fragment>
            {str}
        </React.Fragment>
    );
    }
}
//styleName-percent
class RSPin extends React.Components {
    constructor(props){
        super(props);
    }
    getStyle() {
        var str = '';
        var style = {position:'absolute'};
        style[this.props.styleName.OtherSide] + '0';
        style[this.props.styleName.Thickness_r] + '100%';
        style[this.props.styleName.Thickness] + '1px';
        style[this.props.styleName.StartSide] = this.props.percent + '%';
        return style;
    }
    render(){
        return(
            '<div class="r-slider-pin" style={this.getStyle()}></div>'
        );
    }
    return ;
}
//start-end-labelStep-styleName-calc
class RSLabels extends React.Components {
    constructor(props){
        super(props);
    }
    render(){
        if (!this.props.labelStep) { return ""; }
        var value = this.props.start;
        var str = [];
        while (value <= this.props.end) {
            var percent = this.props.calc.getPercentByValue(value);
            str.push(<RSLabel styleName={this.props.styleName} percent={percent} value={value} />);
            value += this.props.labelStep;
        }
        return(
            <React.Fragment>
                {str}
            </React.Fragment>
        );
    }
}
//percent-styleName-value
class RSLabel extends React.Components {
    constructor(props){
        super(props);
    }
    getStyle() {
        var style = {position: 'absolute',lineHeight: '2px',textAlign: 'center'};
        style[this.props.styleName.Thickness] ='40px';
        style[this.props.styleName.Thickness_r] = '2px';
        style[this.props.styleName.StartSide] = 'calc(' + this.props.percent + '% - 20px)';
        return style;
    }
    render(){
        return(
            '<div class="r-slider-label" style={this.getStyle()}><span>'+
            '{this.props.value}'+
            '</span></div>'
        );
    }
}

//style-index-value-styleName
class RSFill extends React.Components {
    constructor(props){
        super(props);
    }
    getStyle() {
        var style = {position: 'absolute',zIndex:'10',cursor: 'pointer'};
        style[this.props.styleName.Thickness] = '100%';
        style[this.props.styleName.StartSide] = '0';
        style[this.props.styleName.OtherSide] = 'calc(50% - ' + (this.props.style.line_width / 2) + 'px)';
        style[this.props.styleName.Thickness_r] = this.props.style.line_width + 'px';
        return style;
    }
    render(){
        this.render(
            '<div data-index={this.props.index} className="r-slider-fill" style={this.getStyle()}></div>'
        );
    }
}

//calc-styleName-index-value-direction-text-style-showFill
class RSSpace extends React.Components {
    constructor(props){
        super(props);
    }
    getStyle() {
        var percent = this.props.calc.getPercentByValue(this.props.value[this.props.index]);
        if (percent === undefined) { percent = 100; } //for end space
        var beforePercent = (this.props.index === 0) ? 0 : this.props.calc.getPercentByValue(this.props.value[this.props.index - 1]);
        var style = {position:'absolute',zIndex:'100',overflow: 'hidden',cursor:'pointer'};
        style[this.props.styleName.Thickness] = (percent - beforePercent) + '%';
        style[this.props.styleName.StartSide] = beforePercent + '%';
        style[this.props.styleName.OtherSide] = 0;
        style[this.props.styleName.Thickness_r] = '100%';
        return style;
    }
    render(){
        var fill = [];
        var text = [];
        if (this.props.value.length === 1 || this.props.index !== 0) {
            if (this.props.index !== this.props.value.length && this.props.showFill === true) {
                fill.push(<RSFill style={this.props.style} index={this.props.index} styleName={this.props.styleName} value={this.props.value } />);
            }
        }
        if (this.props.text) {
            if (this.props.direction === "left" || this.props.direction === "right") { 
                text.push(<RSText index={this.props.index} length={this.props.value.length} style={this.props.style} styleName={this.props.styleName} text={this.props.text } />);
            }
        }
    }
    render(){
        return(
            '<div data-index={this.props.index} className="r-slider-space" style={this.getStyle()}>'+
            '{fill}{text}'+
            '</div>'
        );
    }
}
//style-styleName-length-index-text
class RSText extends React.Components {
    constructor(props){
        super(props);
    }
    getStyle() {
        var size = this.props.style['button_' + sn.Thickness];
        var style = {position:'absolute',textAlign:'center'};
        if (this.props.index === 0) {
            style[this.props.styleName.Thickness] = 'calc(100% - ' + size / 2 + 'px)';
            style[this.props.styleName.StartSide] = '0';
            style[this.props.styleName.OtherSide] = '0';
        } else if (this.props.index === this.props.length) {
            style[this.props.styleName.Thickness] = 'calc(100% - ' + size / 2 + 'px)';
            style[this.props.styleName.EndSide] = '0';
            style[this.props.styleName.OtherSide] = '0';
        } else {
            style[this.props.styleName.Thickness] = '100%';
        }
        style.lineHeight = this.props.style.button_height + 'px';
        return style;
    }
    render(){
        return(
            '<div data-index={this.props.index} className="r-slider-text" style={this.getStyle()}>'+
            '{this.props.text || ""}'+
            '</div>'
        );
    }
}
//style-styleName
class RSLine extends React.Components {
    constructor(props){
        super(props);
    }
    getStyle() {
        var style = {position:'absolute',zIndex:'1'};
        style[this.props.styleName.Thickness] = '100%';
        style[this.props.styleName.StartSide] = '0';
        style[this.props.styleName.OtherSide] = 'calc(50% - ' + (this.props.style.line_width / 2) + 'px)';
        style[this.props.styleName.Thickness_r] = this.props.style.line_width + 'px';
        return style;
    }
    render(){
        return(
        '<div class="r-slider-line" style={this.getStyle()}></div>'
        );
    }
}
//value-index-style-thickness-styleName-fixValue-showValue
class RSButton extends React.Components {
    constructor(props){
        super(props);
    }
    getStyle() {
        var percent = this.props.calc.getPercentByValue(this.props.value[this.props.index]);
        var size = this.props.style['button_' + sn.Thickness];
        var style = {border:'none',position:'absolute',zIndex: 1000,cursor:'pointer'};
        style['height'] = this.props.style.button_height + 'px;';
        style['width'] = this.props.style.button_width + 'px;';
        style[this.props.styleName.StartSide] = 'calc(' + percent + '% - ' + (size / 2) + 'px)';
        style[this.props.styleName.OtherSide] = '0';
        return style;
    }
    render(){
        var showValue="";
        if (this.props.showValue) { 
            showValue = <RSNumber style={this.props.style} value={this.props.value[this.props.index]} fixValue={this.props.fixValue} index={this.props.index} />; 
        }
        return(
            '<div data-index={this.props.index} data-value={this.props.value[this.props.index]} className="r-slider-button" style={this.getStyle()}>'+
                '{showValue}'+
            '</div>'
        );
    }
}
//style-fixValue-index-number
class RSNumber extends React.Components {
    constructor(props){
        super(props);
    }
    getStyle() {
        var style = {zIndex: 1000};
        if (this.props.fixValue !== true) { style.display='none'; }
        return style;
    }
    render(){
        return(
            '<div data-index={this.props.index} style={this.getStyle()} className="r-slider-number">'+
            '{this.props.value}'+
            '</div>'
        );
    }
}
