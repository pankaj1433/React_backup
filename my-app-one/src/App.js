import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import darkBaseTheme from 'material-ui/styles/baseThemes/darkBaseTheme';
import MuiThemeProvider from 'material-ui/styles/MuiThemeProvider';
import getMuiTheme from 'material-ui/styles/getMuiTheme';
import './App.css';
import AppBar from 'material-ui/AppBar';
import Appbarexample from './Mat/Appbarexample';
import ModalExample from '../src/Mat/ModalExample'

class App extends Component {
  
  
  
  render() {
    return (
            <MuiThemeProvider>
              {/* <Appbarexample /> */}
              <ModalExample />
            </MuiThemeProvider>
            );
  }
}

export default App

