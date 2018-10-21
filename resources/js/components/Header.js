import React, { Component } from 'react';

class Header extends Component{
    render() {

        let dat = new Date();
        let alpha = new Date(dat.getFullYear(),dat.getMonth()+1,1);

        return (
            <header id="main-header">
                <h2 className="display-2">ACOMPANHAMENTO DE INCIDENTES - PERÍODO { alpha.toLocaleDateString() } À { dat.toLocaleDateString() }</h2>
            </header>
        );
    }
}

export default Header;
