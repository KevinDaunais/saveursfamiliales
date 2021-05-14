import Partools from '../partools';

if( Partools.isBrowser('IE') ) String.prototype.includes = function(substring){
	return this.indexOf(substring) !== -1;
};
