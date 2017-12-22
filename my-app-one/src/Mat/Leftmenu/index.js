import React, { Component } from 'react';
import Drawer from 'material-ui/Drawer';
import MenuItem from 'material-ui/MenuItem';

class Leftmenu extends Component {
  render() {
    return (
              <Drawer
                docked={false}
                width={200}
                open={this.props.handler}
                onRequestChange={(open) => this.setState({open})}>
                <MenuItem onClick={this.props.handleclose.bind()}>Menu Item</MenuItem>
                <MenuItem onClick={this.props.handleclose.bind()}>Menu Item 2</MenuItem>
              </Drawer>
            );
  }
}
export default Leftmenu;