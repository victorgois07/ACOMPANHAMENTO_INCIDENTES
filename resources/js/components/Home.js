import React, { Component } from 'react';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.min';
import 'popper.js/dist/popper.min';
import Table from './Table';
import Header from './Header';

import './app.css';

class Home extends Component{
    render() {
        return (
            <div className="container-fluir">
                <Header/>
                <Table/>
            </div>
        );
    }
}

export default Home;
