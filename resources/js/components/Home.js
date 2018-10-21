import React, { Component } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.min';
import $ from 'jquery';
import 'popper.js/dist/popper.min';
import Header from './Header';

import './app.css';

class Home extends Component{
    render() {
        return (
            <div className="container-fluir">
                <Header/>
                
            </div>
        );
    }
}

export default Home;
