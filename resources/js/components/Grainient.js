/**
 * Grainient - OGL-based gradient background with noise and animation
 * Inspired by reactbits.dev Grainient component
 * Uses gold/onyx color scheme
 */

class Grainient {
  constructor(container, options = {}) {
    this.container = container;
    this.options = {
      timeSpeed: options.timeSpeed || 0.25,
      colorBalance: options.colorBalance || 0.0,
      warpStrength: options.warpStrength || 1.0,
      warpFrequency: options.warpFrequency || 5.0,
      warpSpeed: options.warpSpeed || 2.0,
      warpAmplitude: options.warpAmplitude || 50.0,
      blendAngle: options.blendAngle || 0.0,
      blendSoftness: options.blendSoftness || 0.05,
      rotationAmount: options.rotationAmount || 500.0,
      noiseScale: options.noiseScale || 2.0,
      grainAmount: options.grainAmount || 0.1,
      grainScale: options.grainScale || 2.0,
      grainAnimated: options.grainAnimated !== undefined ? options.grainAnimated : false,
      contrast: options.contrast || 1.5,
      gamma: options.gamma || 1.0,
      saturation: options.saturation || 1.0,
      centerX: options.centerX || 0.0,
      centerY: options.centerY || 0.0,
      zoom: options.zoom || 0.9,
      color1: options.color1 || '#D4AF37', // Gold
      color2: options.color2 || '#0D0D0D', // Onyx
      color3: options.color3 || '#F9F7F2', // Linen
    };

    this.renderer = null;
    this.gl = null;
    this.program = null;
    this.mesh = null;
    this.animationId = null;
    this.t0 = 0;

    this.init();
  }

  hexToRgb(hex) {
    const result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
    if (!result) return [1, 1, 1];
    return [
      parseInt(result[1], 16) / 255,
      parseInt(result[2], 16) / 255,
      parseInt(result[3], 16) / 255
    ];
  }

  get vertexShader() {
    return `#version 300 es
in vec2 position;
void main() {
  gl_Position = vec4(position, 0.0, 1.0);
}
`;
  }

  get fragmentShader() {
    return `#version 300 es
precision highp float;
uniform vec2 iResolution;
uniform float iTime;
uniform float uTimeSpeed;
uniform float uColorBalance;
uniform float uWarpStrength;
uniform float uWarpFrequency;
uniform float uWarpSpeed;
uniform float uWarpAmplitude;
uniform float uBlendAngle;
uniform float uBlendSoftness;
uniform float uRotationAmount;
uniform float uNoiseScale;
uniform float uGrainAmount;
uniform float uGrainScale;
uniform float uGrainAnimated;
uniform float uContrast;
uniform float uGamma;
uniform float uSaturation;
uniform vec2 uCenterOffset;
uniform float uZoom;
uniform vec3 uColor1;
uniform vec3 uColor2;
uniform vec3 uColor3;
out vec4 fragColor;
#define S(a,b,t) smoothstep(a,b,t)
mat2 Rot(float a){float s=sin(a),c=cos(a);return mat2(c,-s,s,c);}
vec2 hash(vec2 p){p=vec2(dot(p,vec2(2127.1,81.17)),dot(p,vec2(1269.5,283.37)));return fract(sin(p)*43758.5453);}
float noise(vec2 p){vec2 i=floor(p),f=fract(p),u=f*f*(3.0-2.0*f);float n=mix(mix(dot(-1.0+2.0*hash(i+vec2(0.0,0.0)),f-vec2(0.0,0.0)),dot(-1.0+2.0*hash(i+vec2(1.0,0.0)),f-vec2(1.0,0.0)),u.x),mix(dot(-1.0+2.0*hash(i+vec2(0.0,1.0)),f-vec2(0.0,1.0)),dot(-1.0+2.0*hash(i+vec2(1.0,1.0)),f-vec2(1.0,1.0)),u.x),u.y);return 0.5+0.5*n;}
void mainImage(out vec4 o, vec2 C){
  float t=iTime*uTimeSpeed;
  vec2 uv=C/iResolution.xy;
  float ratio=iResolution.x/iResolution.y;
  vec2 tuv=uv-0.5+uCenterOffset;
  tuv/=max(uZoom,0.001);

  float degree=noise(vec2(t*0.1,tuv.x*tuv.y)*uNoiseScale);
  tuv.y*=1.0/ratio;
  tuv*=Rot(radians((degree-0.5)*uRotationAmount+180.0));
  tuv.y*=ratio;

  float frequency=uWarpFrequency;
  float ws=max(uWarpStrength,0.001);
  float amplitude=uWarpAmplitude/ws;
  float warpTime=t*uWarpSpeed;
  tuv.x+=sin(tuv.y*frequency+warpTime)/amplitude;
  tuv.y+=sin(tuv.x*(frequency*1.5)+warpTime)/(amplitude*0.5);

  vec3 colLav=uColor1;
  vec3 colOrg=uColor2;
  vec3 colDark=uColor3;
  float b=uColorBalance;
  float s=max(uBlendSoftness,0.0);
  mat2 blendRot=Rot(radians(uBlendAngle));
  float blendX=(tuv*blendRot).x;
  float edge0=-0.3-b-s;
  float edge1=0.2-b+s;
  float v0=0.5-b+s;
  float v1=-0.3-b-s;
  vec3 layer1=mix(colDark,colOrg,S(edge0,edge1,blendX));
  vec3 layer2=mix(colOrg,colLav,S(edge0,edge1,blendX));
  vec3 col=mix(layer1,layer2,S(v0,v1,tuv.y));

  vec2 grainUv=uv*max(uGrainScale,0.001);
  if(uGrainAnimated>0.5){grainUv+=vec2(iTime*0.05);}
  float grain=fract(sin(dot(grainUv,vec2(12.9898,78.233)))*43758.5453);
  col+=(grain-0.5)*uGrainAmount;

  col=(col-0.5)*uContrast+0.5;
  float luma=dot(col,vec3(0.2126,0.7152,0.0722));
  col=mix(vec3(luma),col,uSaturation);
  col=pow(max(col,0.0),vec3(1.0/max(uGamma,0.001)));
  col=clamp(col,0.0,1.0);

  o=vec4(col,1.0);
}
void main(){
  vec4 o=vec4(0.0);
  mainImage(o,gl_FragCoord.xy);
  fragColor=o;
}
`;
  }

  init() {
    if (!this.container) return;

    // Create canvas element
    const canvas = document.createElement('canvas');
    this.container.appendChild(canvas);

    // Check for WebGL2 support
    const gl = canvas.getContext('webgl2') || canvas.getContext('webgl');
    if (!gl) {
      console.warn('WebGL not supported, Grainient not initialized');
      return;
    }

    this.gl = gl;

    // Set canvas dimensions
    const width = this.container.clientWidth;
    const height = this.container.clientHeight;
    canvas.width = width;
    canvas.height = height;

    // Compile shaders and create program
    const vs = this.createShader(gl.VERTEX_SHADER, this.vertexShader);
    const fs = this.createShader(gl.FRAGMENT_SHADER, this.fragmentShader);
    this.program = this.createProgram(vs, fs);

    // Set up geometry (full-screen triangle)
    const positions = new Float32Array([-1, -1, 3, -1, -1, 3]);
    const buffer = gl.createBuffer();
    gl.bindBuffer(gl.ARRAY_BUFFER, buffer);
    gl.bufferData(gl.ARRAY_BUFFER, positions, gl.STATIC_DRAW);

    const positionLoc = gl.getAttribLocation(this.program, 'position');
    gl.enableVertexAttribArray(positionLoc);
    gl.vertexAttribPointer(positionLoc, 2, gl.FLOAT, false, 0, 0);

    // Set up uniforms
    this.uniforms = {
      iResolution: { value: [width, height] },
      iTime: { value: 0 },
      uTimeSpeed: { value: this.options.timeSpeed },
      uColorBalance: { value: this.options.colorBalance },
      uWarpStrength: { value: this.options.warpStrength },
      uWarpFrequency: { value: this.options.warpFrequency },
      uWarpSpeed: { value: this.options.warpSpeed },
      uWarpAmplitude: { value: this.options.warpAmplitude },
      uBlendAngle: { value: this.options.blendAngle },
      uBlendSoftness: { value: this.options.blendSoftness },
      uRotationAmount: { value: this.options.rotationAmount },
      uNoiseScale: { value: this.options.noiseScale },
      uGrainAmount: { value: this.options.grainAmount },
      uGrainScale: { value: this.options.grainScale },
      uGrainAnimated: { value: this.options.grainAnimated ? 1.0 : 0.0 },
      uContrast: { value: this.options.contrast },
      uGamma: { value: this.options.gamma },
      uSaturation: { value: this.options.saturation },
      uCenterOffset: { value: [this.options.centerX, this.options.centerY] },
      uZoom: { value: this.options.zoom },
      uColor1: { value: this.hexToRgb(this.options.color1) },
      uColor2: { value: this.hexToRgb(this.options.color2) },
      uColor3: { value: this.hexToRgb(this.options.color3) }
    };

    // Set canvas style
    canvas.style.width = '100%';
    canvas.style.height = '100%';
    canvas.style.display = 'block';
    canvas.style.position = 'absolute';
    canvas.style.top = '0';
    canvas.style.left = '0';
    canvas.style.zIndex = '-1';

    this.container.style.position = 'relative';
    this.container.appendChild(canvas);

    // Handle resize
    this.resizeObserver = new ResizeObserver(() => this.resize());
    this.resizeObserver.observe(this.container);

    // Start animation
    this.t0 = performance.now();
    this.animate();
  }

  createShader(type, source) {
    const shader = this.gl.createShader(type);
    this.gl.shaderSource(shader, source);
    this.gl.compileShader(shader);
    if (!this.gl.getShaderParameter(shader, this.gl.COMPILE_STATUS)) {
      console.error('Shader compile error:', this.gl.getShaderInfoLog(shader));
      this.gl.deleteShader(shader);
      return null;
    }
    return shader;
  }

  createProgram(vs, fs) {
    const program = this.gl.createProgram();
    this.gl.attachShader(program, vs);
    this.gl.attachShader(program, fs);
    this.gl.linkProgram(program);
    if (!this.gl.getProgramParameter(program, this.gl.LINK_STATUS)) {
      console.error('Program link error:', this.gl.getProgramInfoLog(program));
      return null;
    }
    return program;
  }

  resize() {
    if (!this.gl || !this.program) return;
    const width = this.container.clientWidth;
    const height = this.container.clientHeight;
    this.gl.canvas.width = width;
    this.gl.canvas.height = height;
    this.gl.viewport(0, 0, width, height);
    this.uniforms.iResolution.value = [width, height];
  }

  animate() {
    if (!this.gl || !this.program) return;

    const time = (performance.now() - this.t0) * 0.001;
    this.uniforms.iTime.value = time;

    this.gl.useProgram(this.program);

    // Bind all uniforms
    for (const [name, uniform] of Object.entries(this.uniforms)) {
      const location = this.gl.getUniformLocation(this.program, name);
      if (location === null) continue;

      const value = uniform.value;
      if (typeof value === 'number') {
        this.gl.uniform1f(location, value);
      } else if (value.length === 2) {
        this.gl.uniform2f(location, value[0], value[1]);
      } else if (value.length === 3) {
        this.gl.uniform3f(location, value[0], value[1], value[2]);
      } else if (value.length === 4) {
        this.gl.uniform4f(location, value[0], value[1], value[2], value[3]);
      }
    }

    // Draw full-screen triangle
    this.gl.drawArrays(this.gl.TRIANGLES, 0, 3);

    this.animationId = requestAnimationFrame(() => this.animate());
  }

  destroy() {
    if (this.animationId) {
      cancelAnimationFrame(this.animationId);
    }
    if (this.resizeObserver) {
      this.resizeObserver.disconnect();
    }
    if (this.gl && this.program) {
      this.gl.deleteProgram(this.program);
    }
  }
}

// Export for use
window.Grainient = Grainient;
