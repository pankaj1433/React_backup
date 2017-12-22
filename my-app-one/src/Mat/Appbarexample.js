import React, { Component } from 'react';
import AppBar from 'material-ui/AppBar';
import FlatButton from 'material-ui/FlatButton';
import Drawer from 'material-ui/Drawer';
import MenuItem from 'material-ui/MenuItem';
import Leftmenu from './Leftmenu'

class Appbarexample extends Component {
  
  constructor(props) {
    super(props);
    this.state = {
      open: false
    };
  }
 
  handleToggle = () => this.setState({open: !this.state.open});

  handleClose = () => this.setState({open: false});
    
 
  render() {
    return (
            <div>
              <AppBar
                title="First Application"
                onLeftIconButtonTouchTap={this.handleToggle}
                iconClassNameRight="fa fa-ellipsis-h"
              />
              <Leftmenu handler = {this.state.open} handleclose = {() => this.handleClose()}/>
            </div>
            
            
            );
  }
}

/* <input
type="text"
placeholder="Enter Todo"
onChange={(e) => this.setState({ description: e.target.value })}
value={this.state.description}
/>*/


export default Appbarexample;